<?php

namespace Totocsa\IceCommands\Traits;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Application;

trait ReConfig
{
    public function reConfig()
    {
        $currentVersion = Application::VERSION;
        $versionDir = $this->getVersionDir(realpath(__DIR__ . '' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'versions'), $currentVersion);

        if ($versionDir === false) {
            $this->error("There is no modifier replacement directory for version $currentVersion or earlier.");
            return false;
        } else {
            $this->newLine();
            $this->line("Modifier directory: " . last(explode(DIRECTORY_SEPARATOR, $versionDir)));

            $successFillCopies = $this->fillCopies($versionDir);
            if ($successFillCopies) {
                return $this->copying();
            } else {
                return false;
            }
        }
    }

    function getVersionDir(string $baseDir, string $currentVersion)
    {
        $dir = $baseDir . DIRECTORY_SEPARATOR . $currentVersion;
        if (is_dir($dir)) {
            return  $dir;
        } else {
            $dirs = scandir($baseDir);
            if ($dirs === false) {
                return false;
            }

            $dirs = array_filter($dirs, fn($d) => $d !== '.' && $d !== '..');

            usort($dirs, 'version_compare');
            $dirs = array_reverse($dirs);

            foreach ($dirs as $version) {
                if (version_compare($version, $currentVersion, '<')) {
                    return $baseDir . DIRECTORY_SEPARATOR . $version;
                }
            }

            return false;
        }
    }

    protected function copying()
    {
        foreach ($this->copies as $v) {
            $info = new \SplFileInfo($v['target']);
            $dir = $info->getPathInfo()->getPathname();
            if (!is_dir($dir)) {
                mkdir($dir, 0775, true);
            }


            $this->fileSystem->copy($v['source'], $v['target']);

            $this->newLine();

            if ($v['lineEndings'] === false) {
                $this->warn("The installed and original files are the same, but the line endings are different.");
            }

            $this->info("Copy: {$v['source']}");
            $this->info("To: {$v['target']}");
        }

        return true;
    }

    protected function fillCopies($versionDir)
    {
        $modifiedBaseDir = $versionDir . DIRECTORY_SEPARATOR . 'modified';
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($modifiedBaseDir, \FilesystemIterator::SKIP_DOTS)
        );

        $this->fileSystem = new Filesystem();
        $appBasePath = app()->basePath();

        $success = true;
        foreach ($iterator as $file) {
            $modified = $file->getPathname();
            $relative = substr($modified, strlen($modifiedBaseDir) + 1);
            $original = $versionDir  . DIRECTORY_SEPARATOR . 'original' . DIRECTORY_SEPARATOR . $relative;
            $installed = $appBasePath . DIRECTORY_SEPARATOR . $relative;

            $success = $success && $this->addToCopies($installed, $original, $modified);

            if (!$success) {
                break;
            }
        }

        return $success;
    }

    protected function addToCopies($installed, $original, $modified)
    {
        $isInstalled = is_file($installed);

        if ($isInstalled) {
            $installedContent = file_get_contents($installed);
            $modifiedContent = file_get_contents($modified);

            if ($installedContent === $modifiedContent) {
                return true;
            }
        }

        $isOriginal = is_file($original);

        if (!$isInstalled) {
            $this->copies[] = ['source' => $modified, 'target' => $installed, 'lineEndings' => true];
            return true;
        } else {
            if ($isOriginal) {
                $installedContent = file_get_contents($installed);
                $originalContent = file_get_contents($original);

                if ($installedContent === $originalContent) {
                    $this->copies[] = ['source' => $modified, 'target' => $installed, 'lineEndings' => true];
                    return true;
                } else {
                    $normalizedInstalledContent = $this->normalizeLineEndings($installedContent);
                    $normalizedOriginalContent = $this->normalizeLineEndings($originalContent);

                    if ($normalizedInstalledContent === $normalizedOriginalContent) {
                        $this->copies[] = ['source' => $modified, 'target' => $installed, 'lineEndings' => false];

                        return true;
                    } else {
                        $this->error("The installed and original files are not same:");
                        $this->warn($installed);
                        $this->warn($original);

                        return false;
                    }
                }
            } else {
                $installedContent = file_get_contents($installed);
                $modifiedContent = file_get_contents($modified);

                if ($installedContent === $modifiedContent) {
                    return true;
                } else {
                    $this->error("There are installed and modified files that are not the same and there is no original file."
                        . " So it is not possible to decide whether to replace the installed file with the modified one.");
                    $this->error("Installed file: $installed");
                    $this->error("Original file: $original");

                    return false;
                }
            }
        }
    }

    function normalizeLineEndings(string $text): string
    {
        return preg_replace("/\r\n?/", "\n", $text);
    }
}

<?php
/**
 * An example of a project-specific implementation.
 *
 * After registering this autoload function with SPL, the following line
 * would cause the function to attempt to load the \Foo\Bar\Baz\Qux class
 * from /path/to/project/src/Baz/Qux.php:
 *
 *      new \Foo\Bar\Baz\Qux;
 *
 * @param string $class The fully-qualified class name.
 * @return void
 */

namespace RozbynDev;

use RuntimeException;

class Autoloader
{
    // project-specific namespace prefix
    protected static string $prefix = 'RozbynDev\\';

    public static function getPrefix(): string
    {
        return self::$prefix;
    }

    public static function setPrefix(string $prefix): void
    {
        self::$prefix = $prefix;
    }


    // base directories for the namespace prefix
    protected static array $baseDirs = [
    ];

    public static function getBaseDirs(): array
    {
        return self::$baseDirs;
    }

    public static function addBaseDir(string $dirPath): void
    {
        if (is_dir($dirPath)) {
            self::$baseDirs[] = $dirPath;
        } else {
            throw new RuntimeException("Dir $dirPath not exist");
        }
    }

    public static function clearBaseDirs(): void
    {
        self::$baseDirs = [];
    }


    public static function register(): void
    {
        spl_autoload_register([__CLASS__, 'loadClass']);
    }


    public static function loadClass(string $class): void
    {
        // does the class use the namespace prefix?
        $len = strlen(self::$prefix);
        if (strncmp(self::$prefix, $class, $len) !== 0) {
            // no, move to the next registered autoloader
            return;
        }

        // get the relative class name
        $relativeClass = substr($class, $len);

        // replace the namespace prefix with the base directory, replace namespace
        // separators with directory separators in the relative class name, append
        // with .php
        foreach (self::$baseDirs as $baseDir) {
            $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

            // if the file exists, require it
            if (file_exists($file)) {
                require_once $file;
            }
        }
    }
}

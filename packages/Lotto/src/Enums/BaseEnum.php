<?php

namespace Lotto\Enums;

class BaseEnum
{
    private $name;
    private static $reflections = [];
    private static $instances = [];


    final private function __construct(string $name)
    {
        $this->name = $name;
    }


    final public static function createByName(string $name)
    {
        $canonicalName = strtoupper($name);
        if ($canonicalName !== $name) {
            $name = $canonicalName;
        }

        $const = static::getConstList();
        if (!array_key_exists($name, $const)) {
            throw new \Exception('Unknow member ' . $name);
        }

        return static::createNamedInstance($name);
    }

    public static function getConstList(): array
    {
        return self::getEnumReflection(static::class)->getConstants();
    }

    private static function getEnumReflection(string $class): \ReflectionClass
    {
        if (!array_key_exists($class, self::$reflections)) {
            try {
                self::$reflections[$class] = new \ReflectionClass($class);
            } catch (\ReflectionException $e) {
                throw new \LogicException('Class should be valid FQCN. Fix internal calls.');
            }
        }

        return self::$reflections[$class];
    }

    private static function createNamedInstance(string $name)
    {
        $class = get_called_class();
        $key = self::getConstKey($class, $name);

        if (!array_key_exists($key, self::$instances)) {
            self::$instances[$key] = new static($name);
        }

        return self::$instances[$key];
    }


    private static function getConstKey(string $class, string $name): string
    {
        return $class . '::' . $name;
    }

    final public static function __callStatic(string $name, array $arguments)
    {
        return static::createByName($name);
    }

    final public function getName(): string
    {
        return $this->name;
    }
    public function getValue()
    {
        $const = static::getConstList();
        return array_key_exists($this->getName(), $const) ? $const[$this->getName()] : '';
    }

    final public function __toString(): string
    {
        return $this->getName();
    }

    public static function getByValue($value)
    {
        $const = static::getConstList();

        foreach ($const as $key => $item) {
            if ($item == $value) {
                return static::createByName($key);
            }
        }
        return null;
    }
    public static function getListDescSorted()
    {
        $consts = static::getConstList();
        uasort($consts, function ($a, $b) {
            return $b - $a;
        });
        return $consts;
    }
    public static function getListAscSorted()
    {
        $consts = static::getConstList();
        uasort($consts, function ($a, $b) {
            return $a - $b;
        });
        return $consts;
    }
}

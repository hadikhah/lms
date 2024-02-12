<?php


namespace Modules\User\Services;


use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\SimpleCache\InvalidArgumentException;

class VerifyCodeService
{
    /**
     * minimum amount possible for the verification code
     * @var int
     */
    private static int $min = 100000;
    /**
     * minimum amount possible for the verification code
     * @var int
     */
    private static int $max = 999999;
    /**
     * verification code prefix key (saving key prefix)
     * @var string
     */
    private static string $prefix = 'verify_code_';
    /**
     * verification store time
     * @var string
     */
    private static string $statusPrefix = 'status';
    /**
     * maximum delay for user to ask to resent activation code
     * @var int
     */
    private static int $resendDelayMinutes = 2;


    /**
     * @returns int
     */
    public static function generate(): int
    {
        return random_int(self::$min, self::$max);
    }

    /**
     * stores the verification code in cache
     *
     * @param $id
     * @param $code
     * @param $time
     * @return void
     * @throws InvalidArgumentException
     */
    public static function store($id, $code, $time): void
    {
        cache()->set(
            self::$prefix . $id,
            $code,
            $time
        );
        self::setStoreStatus($id);
    }

    /**
     * saves the time of storing the code
     *
     * @throws InvalidArgumentException
     */
    public static function setStoreStatus($id): void
    {
        cache()->set(
            self::$prefix . self::$statusPrefix . $id, now(), now()->addMinutes(self::$resendDelayMinutes)
        );

    }

    /**
     * returns if the status cache is expired or not
     *
     * @param $id
     * @return bool
     */
    public static function checkStatus($id): bool
    {
        return cache()->has(self::$prefix . self::$statusPrefix . $id);
    }

    /**
     * returns the cache value of status
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public static function getStatus($id)
    {
        return cache()->get(self::$prefix . self::$statusPrefix . $id);
    }

    /**
     * @param $id
     * @return \Closure|mixed|object|null
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public static function get($id): mixed
    {
        return cache()->get(self::$prefix . $id);
    }

    /**
     * checks if the given key is available in cache
     *
     * @param $id
     * @return bool
     */
    public static function has($id): bool
    {
        return cache()->has(self::$prefix . $id);
    }

    /**
     * removes the given key value from the cache
     *
     * @param $id
     * @return bool
     * @throws InvalidArgumentException
     */
    public static function delete($id): bool
    {
        return cache()->delete(self::$prefix . $id);
    }

    /**
     * returns validation rules for verification code input
     * @return string
     */
    public static function getRule(): string
    {
        return 'required|numeric|between:' . self::$min . ',' . self::$max;
    }

    /**
     * checks if the given code matches the code stored for the given id
     *
     * @param $id
     * @param $code
     * @return bool
     * @throws ContainerExceptionInterface
     * @throws InvalidArgumentException
     * @throws NotFoundExceptionInterface
     */
    public static function check($id, $code): bool
    {
        if (self::get($id) != $code) return false;

        self::delete($id);
        return true;
    }
}

<?php
declare(strict_types=1);

namespace Application\Model;

use AthenaCore\Mvc\Model\AbstractModel;

class ApplicationModel extends AbstractModel
{
    /**
     * Return instance by hash.
     *
     * @param string $hash
     * @param bool $useModelInsteadOfEntity
     * @param string|null $table
     * @return mixed
     */
    public static function byHash(string $hash, bool $useModelInsteadOfEntity = false, string $table = null): mixed
    {
        $instance = new static($useModelInsteadOfEntity, $table);
        return $instance -> select(['hash' => $hash]) -> current();
    }

    /**
     * Return instance by id.
     *
     * @param int $id
     * @param bool $useModelInsteadOfEntity
     * @param string|null $table
     * @return mixed
     */
    public static function byId(int $id, bool $useModelInsteadOfEntity = false, string $table = null): mixed
    {
        $instance = new static($useModelInsteadOfEntity, $table);
        return $instance -> select(['id' => $id]) -> current();
    }

    /**
     * Return instance by active status
     *
     * @param bool $useModelInsteadOfEntity
     * @param string|null $table
     * @return mixed
     */
    public static function oneByActiveStatus(bool $useModelInsteadOfEntity = false, string $table = null): mixed
    {
        return static ::oneByStatus(1, $useModelInsteadOfEntity, $table);
    }

    /**
     * Return instance by disabled status.
     *
     * @param bool $useModelInsteadOfEntity
     * @param string|null $table
     * @return mixed
     */
    public static function oneByDisabledStatus(bool $useModelInsteadOfEntity = false, string $table = null): mixed
    {
        return static :: oneByStatus(0, $useModelInsteadOfEntity, $table);
    }

    /**
     * Return instance by status.
     *
     * @param int $status
     * @param bool $useModelInsteadOfEntity
     * @param string|null $table
     * @return mixed
     */
    public static function oneByStatus(int $status, bool $useModelInsteadOfEntity = false, string $table = null): mixed
    {
        $instance = new static($useModelInsteadOfEntity, $table);
        $instance -> select(['status' => $status]);
        return $instance -> fetchOne();
    }
}
<?php
/**
 * @author jrk
 * @copyright 2021 A Road Ahead, LLC
 * @license Apache 2.0
 */
declare(strict_types=1);

/**
 * @package \Application\Entity
 */

namespace Application\Entity;

/**
 * Import statements
 */

use AthenaCore\Mvc\Entity\AbstractEntity;
use Poseidon\Data\DataObject;
use function intval;

/**
 * Class AbstractEntity
 * @abstract
 * @package \Application\Entity
 * @extends DataObject
 */
abstract class ApplicationEntity extends AbstractEntity
{
    /**
     * @return int the entity id
     */
    public function getId(): int
    {
        return intval($this -> get("id"));
    }

    /**
     * @return int the modified by user id
     */
    public function getModifiedby(): int
    {
        return intval($this -> get('modifiedby'));
    }

    /**
     * @return int the parent id. usually used for parent/child hierarchy
     */
    public function getParentid(): int
    {
        return intval($this -> get('parentid'));
    }

    /**
     * @return string|null any record flags
     */
    public function getFlags(): string|null
    {
        return $this -> get('flags');
    }

    /**
     * @return int record sort order
     */
    public function getSort(): int
    {
        return intval($this -> get('sort'));
    }

    /**
     * @return float record revision decimal
     */
    public function getRevision(): float
    {
        return (float)$this -> get('revision');
    }

    /**
     * @return float record version decimal
     */
    public function getVersion(): float
    {
        return (float)$this -> get('version');
    }

    /**
     * @return string|null record description
     */
    public function getDescription(): string|null
    {
        return $this -> get('description');
    }

    /**
     * @return string|null record comment
     */
    public function getComment(): string|null
    {
        return $this -> get('comment');
    }

    /**
     * @return string|null record rawdata. usually in JSON or serialized format.
     */
    public function getRawdata(): string|null
    {
        return $this -> get('rawdata');
    }

    /**
     * @return string record creation date
     */
    public function getCreated(): string
    {
        return $this -> get('created');
    }

    /**
     * @return string record updated date
     */
    public function getUpdated(): string
    {
        return $this -> get('updated');
    }

    /**
     * @return int record status flag
     */
    public function getStatus(): int
    {
        return intval($this -> get('status'));
    }

    /**
     * @return string record hash string
     */
    public function getHash(): string
    {
        return $this -> get('hash');
    }

    /**
     * @return array array format of record data
     */
    public function getArrayCopy(): array
    {
        return $this -> toArray();
    }

    /**
     * @param string $value string value to cast
     * @return int casted integer value from string
     */
    private function translateToInt(string $value): int
    {
        return (int)$value;
    }
}
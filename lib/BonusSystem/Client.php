<?php

namespace RozbynDev\BonusSystem;

use DateTime;
use Exception;
use RozbynDev\Db\Mysqli;
use RozbynDev\Helper\Logger;
use RozbynDev\Tables\BonusSystemTable;

/**
 *
 */
class Client
{
    /**
     * @var array
     */
    protected array $initFields = [];
    /**
     * @var int
     */
    protected int $id;
    /**
     * @var string|null
     */
    protected ?string $name = null;
    /**
     * @var string|null
     */
    protected ?string $phone = null;
    /**
     * @var int|null
     */
    protected ?int $bonusCount = null;
    /**
     * @var bool|null
     */
    protected ?bool $isAdmin = null;
    /**
     * @var string|null
     */
    protected ?string $nextAnswerType = null;

    /**
     * @var DateTime
     */
    protected DateTime $createDate;
    /**
     * @var DateTime
     */
    protected DateTime $modifyDate;


    /**
     * @param array $dbRow
     * @throws Exception
     */
    public function __construct(array $dbRow = [])
    {
        if (empty($dbRow['id'])) {
            throw new \RuntimeException('Id must be positive integer');
        }
        $this->id = (int)$dbRow['id'];
        if (!empty($dbRow['name'])) {
            $this->name = (string)$dbRow['name'];
        }
        if (!empty($dbRow['phone'])) {
            $this->phone = (string)$dbRow['phone'];
        }
        if (!empty($dbRow['bonusCount'])) {
            $this->bonusCount = (int)$dbRow['bonusCount'];
        }
        if (!empty($dbRow['isAdmin'])) {
            $this->isAdmin = (bool)$dbRow['isAdmin'];
        }
        if (!empty($dbRow['nextAnswerType'])) {
            $this->nextAnswerType = (string)$dbRow['nextAnswerType'];
        }
        Logger::getLastLogger()->log($dbRow);
        if (!empty($dbRow['dateCreate'])) {
            $this->createDate = new DateTime($dbRow['dateCreate']);
        }
        if (!empty($dbRow['dateModify'])) {
            $this->modifyDate = new DateTime($dbRow['dateModify']);
        }
        $this->initFields['id'] = $this->id;
        $this->initFields['name'] = $this->name;
        $this->initFields['phone'] = $this->phone;
        $this->initFields['bonusCount'] = $this->bonusCount;
        $this->initFields['isAdmin'] = $this->isAdmin;
        $this->initFields['nextAnswerType'] = $this->nextAnswerType;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string|null $phone
     */
    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return int|null
     */
    public function getBonusCount(): ?int
    {
        return $this->bonusCount;
    }

    /**
     * @param int|null $bonusCount
     */
    public function setBonusCount(?int $bonusCount): void
    {
        $this->bonusCount = $bonusCount;
    }

    /**
     * @return bool
     */
    public function getIsAdmin(): ?bool
    {
        return $this->isAdmin;
    }

    /**
     * @param bool $isAdmin
     */
    public function setIsAdmin(?bool $isAdmin): void
    {
        $this->isAdmin = $isAdmin;
    }

    /**
     * @return DateTime
     */
    public function getCreateDate(): DateTime
    {
        return $this->createDate;
    }

    /**
     * @return DateTime
     */
    public function getModifyDate(): DateTime
    {
        return $this->modifyDate;
    }


    /**
     * @return string|null
     */
    public function getNextAnswerType(): ?string
    {
        return $this->nextAnswerType;
    }

    /**
     * @param string|null $nextAnswerType
     */
    public function setNextAnswerType(?string $nextAnswerType): void
    {
        $this->nextAnswerType = $nextAnswerType;
    }


    /**
     * @param bool $returnOnFirstChange
     * @return array
     */
    public function getChangedFields(bool $returnOnFirstChange = false): array
    {
        $result = [];
        $vars = get_class_vars(__CLASS__);
        unset($vars['initFields'], $vars['createDate'], $vars['modifyDate']);
        foreach ($vars as $fieldName => $temp) {
            if ($this->$fieldName !== $this->initFields[$fieldName]) {
                $result[$fieldName] = $this->$fieldName;
                if ($returnOnFirstChange) {
                    return $result;
                }
            }
        }
        return $result;
    }


    /**
     * @return bool
     * @throws Exception
     */
    public function save(): bool
    {
        if (empty($this->getChangedFields(true))) {
            return false;
        }
        $sql = 'UPDATE ' . BonusSystemTable::getTableName() . ' SET ';
        $sql .= BonusSystemTable::getUpdateFieldsSql($this->getChangedFields());
        $sql .= ' WHERE id=' . $this->getId();
        return (bool)Mysqli::fetchQuery($sql);
    }


    /**
     * @param int $id
     * @return bool|Client
     * @throws Exception
     */
    public static function getById(int $id): bool|Client
    {
        $result = Mysqli::fetchQuery(
            'SELECT * FROM ' . BonusSystemTable::getTableName() . " WHERE `id` = $id;"
        );
        if (is_array($result) && !empty($result)) {
            return new self(current($result));
        }
        d();
        return false;
    }


    /**
     * @param int $id
     * @return bool|Client
     * @throws Exception
     */
    public static function createNewClient(int $id): bool|Client
    {
        $result = Mysqli::fetchQuery(
            'INSERT INTO ' . BonusSystemTable::getTableName() . "(`id`) VALUES ($id);"
        );
        if ($result) {
            return new self(['id' => $id, 'dateCreate' => 'now', 'dateModify' => 'now']);
        }
        return false;
    }

    public static function deleteById(int $id): bool
    {
        $sql = 'DELETE FROM ' . BonusSystemTable::getTableName() . ' WHERE id=' . $id;
        return (bool)Mysqli::fetchQuery($sql);
    }


}

<?php
/**
 * Author: Aleksey Mikhailov
 * Date: 31.01.2020
 * Time: 18:45
 */

namespace app\models\snow\order\status;


abstract class Status
{
    public const STATUS_REJECTED = 0;
    public const STATUS_CREATED = 1;
    public const STATUS_PROCESSING = 2;
    public const STATUS_COMPLETED = 3;

    protected $next;
    protected $index;

    public static function create(int $statusId) :Status
    {
        switch ($statusId) {
            case self::STATUS_REJECTED: return new RejectedStatus();
            case self::STATUS_CREATED: return new CreatedStatus();
            case self::STATUS_PROCESSING: return new ProcessingStatus();
            case self::STATUS_COMPLETED: return new CompletedStatus();
        }
    }

    public function canBeChangedTo(self $status)
    {
        $classname = get_class($status);

        if (!in_array($classname, $this->next, true)) {
            throw new \DomainException('Ошибка изменения статуса');
        }
    }

    abstract public function allowsAcceptingRequest() :bool;

    public function getIndex() :int
    {
        return $this->index;
    }
}
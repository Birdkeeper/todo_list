<?php

namespace TestTask\TodoListBundle\Repository;

use Doctrine\ORM\EntityRepository;
use TestTask\TodoListBundle\Entity\Lists;
use TestTask\TodoListBundle\Entity\Tasks;

class ListsRepository extends EntityRepository
{

    /**
     * @return array
     */
    public function getPublicLists()
   {
       $qb = $this->createQueryBuilder('l')
           ->select('l')
           ->where('l.isDone = 0');

       return $qb->getQuery()
           ->getResult();
   }

    /**
     * @return array
     */
    public function getArchiveLists()
    {
        $qb = $this->createQueryBuilder('l')
            ->select('l')
            ->where('l.isDone = 1');

        return $qb->getQuery()
            ->getResult();
    }

    /**
     * @param $list
     */
    public function deleteList($list)
    {
        $em = $this->getEntityManager();

        /** @var Lists $list*/
        $list->setIsDone(true);
        $tasks = $list->getTask();
        /** @var Tasks $task */
        foreach ($tasks as $task) {
            $task->setIsDone(true);
        }

        $em->persist($list);
        $em->flush();
    }

    /**
     * @param $list
     */
    public function reestablishList($list)
    {
        $em = $this->getEntityManager();

        /** @var Lists $list*/
        $list->setIsDone(false);
        $tasks = $list->getTask();
        /** @var Tasks $task */
        foreach ($tasks as $task) {
            $task->setIsDone(false);
        }

        $em->persist($list);
        $em->flush();
    }

    /**
     * @param $list
     */
    public function createList($list)
    {
        $em = $this->getEntityManager();
        $em->persist($list);
        $em->flush();
    }

}

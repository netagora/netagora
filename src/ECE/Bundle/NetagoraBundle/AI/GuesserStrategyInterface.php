<?php

namespace ECE\Bundle\NetagoraBundle\AI;

interface GuesserStrategyInterface
{
    public function guess();

    public function getName();

    public function getScore();
}
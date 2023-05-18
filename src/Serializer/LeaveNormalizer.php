<?php

namespace App\Serializer;

use App\Entity\Leave;
use App\Service\LeaveCalculator;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class LeaveNormalizer implements NormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    public function __construct(private LeaveCalculator $leaveCalculator)
    {
        
    }
    public function normalize(mixed $object, string $format = null, array $context = [])
    {
        $object->setNumberOfDays($this->leaveCalculator->calculateWorkingDays($object->getStartDate(),$object->getEndDate()));
        return $this->normalizer->normalize($object, $format, $context + [__CLASS__ => true]);
        // return $object;
    }

    
    public function supportsNormalization(mixed $data, string $format = null , array $context = []):bool
    {
        return $data instanceof Leave && !isset($context[__CLASS__]);
    }
    
}
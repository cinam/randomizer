<?php

namespace Cinam\Randomizer;

/**
 * Interface for number generator.
 *
 * @author cinam <cinam@hotmail.com>
 */
interface NumberGeneratorInterface
{
    /**
     * Returns random integer from given range.
     *
     * @param integer $min The minimal value.
     * @param integer $max The maximal value.
     *
     * @return integer
     *
     * @throws InvalidArgumentException If min is greater than max.
     */
    public function getInt($min, $max);

    /**
     * Returns random float from given range.
     *
     * @param float $min The minimal value.
     * @param float $max The maximal value.
     *
     * @return float
     *
     * @throws InvalidArgumentException If min is greater than max.
     */
    public function getFloat($min, $max);
}

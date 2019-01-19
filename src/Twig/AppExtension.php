<?php
/**
 * Created by PhpStorm.
 * User: yamadote
 * Date: 1/19/19
 * Time: 3:11 AM.
 */

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('merge_recursive', [$this, 'mergeRecursive']),
        ];
    }

    public function mergeRecursive(array $all, array $changes): array
    {
        foreach ($changes as $key => $value) {
            if (\is_array($value)) {
                $all[$key] = $this->mergeRecursive($all[$key], $value);
            } else {
                $all[$key] = $value;
            }
        }

        return $all;
    }
}

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
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('merge_recursive', [$this, 'mergeRecursive']),
        ];
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('generate_all_input_hidden', [$this, 'generateInputHidden']),
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

    public function generateInputHidden(array $all, array $exclude = [])
    {
        $html = '';
        foreach (array_diff_key($all, array_flip($exclude)) as $key => $value) {
            if (is_array($value)) {
                $html .= $this->generateInputHidden($this->formatKeysInArray($value, $key.'[%s]'));
            } else {
                $html .= '<input type="hidden" name="'.$key.'" value="'.$value.'">';
            }
        }
        return $html;
    }

    private function formatKeysInArray(array $array, $format) {
        $result = [];
        foreach ($array as $key => $value) {
            $result[sprintf($format, $key)] = $value;
        }
        return $result;
    }
}

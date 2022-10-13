<?php

namespace AAbramenko\HomeWork\Tasks;

final class PackageCounter
{
    /**
     * @param array $settings Массив, где каждая позиция необходимое кол-во товара в упаковке
     * @param int $count
     * @return array Ассоциативный массив, где ключ, кол-во товара в упаковке, кол-во упаковок для покупателя
     */
    public static function getCount(array $settings, int $count) : array {
        // Сортируем по убыванию кол-ва упаковок в товаре
        rsort($settings);

        // Присваиваем упаковкам начальное значение
        $settings = array_combine($settings, array_fill(0, count($settings), 0));

        return self::calcCountPackages ($settings, $count);
    }

    private static function calcCountPackages (array $packages, int $count, int $index = 0) : array {
        // Получаем, все ключи (кол-ва товара в упаковках)
        $keys = array_keys($packages);
        // В зависимости от того на каком этапе мы находимся выбираем нужный ключ
        $countInPackage = $keys[$index];
        // Сразу увеличиваем индекс для перехода к следующей упаковке
        // Ибо проще потом сравнивать, не последний ли это вид упаковки
        $index++;
        // Начальное значение остатка, на тот случай, когда текущее кол-во упаковок больше заказываемого товара
        $remains = $count;
        if ($count >= $countInPackage) {
            // Если кол-во товара больше чем есть в упаковке.
            // Вычисляем сколько упаковок нужно и получаем остаток требуемого товара
            $remains = $count % $countInPackage;
            $packages[$countInPackage] = intdiv($count, $countInPackage);
        } else if ($index === count($keys)) {
            // Если кол-ва товара больше чем в самой маленькой упаковке, тогда
            // всё равно считаем её, ибо нельзя человеку уйти без товара
            $packages[$countInPackage]++;
        }
        if ($index === count($keys)) {
            // Для последней упаковки, если товара было больше чем в упаковке
            // Но остаток остался, увеличиваем кол-во минимальных упаковок
            if ($remains < $count && $remains) {
                $packages[$countInPackage]++;
            }
            return $packages;
        }
        return self::calcCountPackages ($packages, $remains, $index);
    }
}
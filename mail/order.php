    <div class="table-responsive">
        <table style="width: 100%; border: 1px solid #ddd; border-collapse: collapse;">
            <thead>
            <tr style="background: #f9f9f9">
                <th style="padding: 8px; border: 1px solid #ddd;">Наименование</th>
                <th style="padding: 8px; border: 1px solid #ddd;">Количество</th>
                <th style="padding: 8px; border: 1px solid #ddd;">Цена</th>
                <th style="padding: 8px; border: 1px solid #ddd;">Сумма</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($session['cart'] as $id => $item): ?>
            <tr>
                <td style="padding: 8px; border: 1px solid #ddd;"><?= $item['name']?></td>
                <td style="padding: 8px; border: 1px solid #ddd;"><?= $item['qry']?></td>
                <td style="padding: 8px; border: 1px solid #ddd;"><?= $item['price']?></td>
                <td style="padding: 8px; border: 1px solid #ddd;"><?= $item['qry'] * $item['price']?></td>
            </tr>
            <?php endforeach;?>
            <tr>
                <td colspan="3">Итого: </td>
                <td><?= $session['cart.qry'] ?></td>
            </tr>
            <tr>
                <td colspan="3">На сумму: </td>
                <td><?= $session['cart.sum'] ?></td>
            </tr>
            </tbody>
        </table>
    </div>


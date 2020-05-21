<?php $v->layout("_theme.php");?>

<div>
    <h3>Cartas cadastradas</h3>
    <table class="customers">
        <tr>
            <th class="cardTableC1">#</th>
            <th class="cardTableC2">Modelo</th>
            <th class="cardTableC3">Nome destinatário</th>
            <th class="cardTableC4">Endereço</th>
            <th class="cardTableC5">Ações</th>
        </tr>

        <?php
            $i = 1;
            foreach ($cards as $card):
        ?>
            <tr>
                <td style="font-weight: bold"><?= $i ?></td>
                <?php foreach ($models as $model):
                    if($model->id == $card->model_id): ?>
                        <td><?= $model->name ?></td>
                <?php endif; endforeach; ?>
                <td><?= $card->receiver_name ?></td>
                <td><?= $card->receiver_street ?>, <?= $card->receiver_city ?>, <?= $card->receiver_state ?>, <?= $card->receiver_postcode ?></td>
                <td class="dashboardTd">
                    <i class="dashboardFaShare fa fa-share" title="Gerar link compartilhavel" onclick="shareLink('<?= md5($card->id) ?>', '<?= md5($_SESSION['login']['registration']) ?>')"></i> &emsp;
                    <i class="dashboardFaConfirm fa fa-download" title="Baixar carta"></i> &emsp;
                    <i class="dashboardFaTresh fa fa-trash" title="Excluir carta"></i>
                </td>
            </tr>
        <?php $i++; endforeach; ?>
    </table>
</div>

<?php $v->start("scripts"); ?>
<script>
    function shareLink(id, user) {
        let data = {'id':id, 'user': user};
        $.post("<?= $router->route("web.cardShare"); ?>", data, function (e) {
            alert(e);
        }, "html").fail(function () {
            alert("Erro ao processar requisição!");
        });
    }
</script>
<?php $v->end(); ?>
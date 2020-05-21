<?php $v->layout("_theme.php") ?>

    <div id="spinnerDiv" class="spinnerDiv">
        <div class="spinner"></div>
    </div>
    <div class="dashboardDiv">
        <div class="dashboardNav">
            <a class="dashboardNavA">Informações gerais</a>
        </div>
        <div class="dashboardDivChart">
            <div class="dashboardChart1">
                <div id="chart_div"></div>
            </div>
            <div class="dashboardChart2">
                <div id="piechart"></div>
            </div>

            <?php if(!empty($accounts)): ?>
                <div class="dashboardUsersTable">
                    <table class="customers">
                        <tr>
                            <th class="th1">Nome</th>
                            <th class="th2">Matrícula</th>
                            <th class="th3">Email</th>
                            <th class="th4">Órgao</th>
                            <th class="dashboardTd">Ações</th>
                        </tr>

                        <?php foreach ($accounts as $account): ?>
                            <tr>
                                <td><?= $account->name ?></td>
                                <td><?= $account->registration ?></td>
                                <td><?= $account->email ?></td>
                                <td><?= $account->organ ?></td>
                                <td class="dashboardTd"><i class="dashboardFaConfirm fa fa-check-circle" onclick="confirm(<?= $account->id ?>)"></i> &emsp;<i class="dashboardFaTresh fa fa-trash" onclick="remove(<?= $account->id ?>)"></i></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>


<?php $v->start("scripts"); ?>
    <script>
        $("#spinnerDiv").hide();

        <?php
            if(isset($_SESSION['login']['lotSend']) && $_SESSION['login']['lotSend'] == 1):
                unset($_SESSION['login']['lotSend']);
        ?>
                alert("Lote enviado com sucesso");
        <?php
            elseif(isset($_SESSION['login']['lotSend']) && $_SESSION['login']['lotSend'] == 2):
                unset($_SESSION['login']['lotSend']);
        ?>
            alert("Não há lotes para serem enviados");
        <?php
            endif;
        ?>

        <?php if(!empty($account)): ?>
            function confirm(id) {
                $("#spinnerDiv").show();
                let data = {'id':id, 'name': '<?= $account->name ?>', 'email': '<?= $account->email ?>'};
                $.post("<?= $router->route("web.confirmAccount"); ?>", data, function (e) {
                    alert(e);
                    window.location.reload();
                }, "html").fail(function () {
                    alert("Erro ao processar requisição!");
                });
            }

            function remove(id) {
                $("#spinnerDiv").show();
                let data = {'id':id, 'name': '<?= $account->name ?>', 'email': '<?= $account->email ?>'};
                $.post("<?= $router->route("web.removeAccount"); ?>", data, function (e) {
                    alert(e);
                    window.location.reload();
                }, "html").fail(function () {
                    alert("Erro ao processar requisição!");
                });
            }
        <?php endif; ?>
    </script>
    
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawVisualization);

        function drawVisualization() {
            // Some raw data (not necessarily accurate)
            var data = google.visualization.arrayToDataTable([
                ['Mês', 'Quantidade'],
                ['Janeiro',  165],
                ['Fevereiro',  135],
                ['Março',  157],
                ['Abril',  139]
            ]);

            var options = {
                title : 'Cartas enviadas',
                vAxis: {title: 'Cartas'},
                hAxis: {title: 'Mês'},
                seriesType: 'bars',
                series: {5: {type: 'line'}}};
    
            var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        }   
    </script>
    
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Notificação de contrução',     314],
          ['Modelo de teste',      282],
          // ['Commute',  2],
          // ['Watch TV', 2],
          // ['Sleep',    7]
        ]);

        var options = {
          title: 'Modelos enviados'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>
<?php $v->end(); ?>

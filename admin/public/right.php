<main class="col-sm-9 offset-sm-3 offset-md-2 pt-3" role="main">
    <h2>Section title</h2>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>Header</th>
                <th>Header</th>
                <th>Header</th>
                <th>Header</th>
            </tr>
            </thead>
            <tbody>
            <?php
                foreach($list as $k=>$v) {
                    ?>
                    <tr>
                        <td><?= $v['']?></td>
                        <td>Lorem</td>
                        <td>ipsum</td>
                        <td>dolor</td>
                        <td>sit</td>
                    </tr>
                    <?php
                }
            ?>
            </tbody>
        </table>
    </div>
</main>
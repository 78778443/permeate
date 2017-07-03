


<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h4 class="pull-left page-title">Basic Tables</h4>
                    <ol class="breadcrumb pull-right">
                        <li>
                            <a class="btn btn-success" href="/">按钮</a>
                        </li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">帖子数据列表</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Username</th>
                                                <th>Age</th>
                                                <th>City</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach ($row as $part) {
                                            $sql = "select count(*) as cou from " . DB_PRE . "cate where pid='" . $part['id'] . "' group by pid";
                                            //echo $sql;
                                            $row1 = mysql_func($sql);

                                            $cou = $row1[0]['cou'];
                                            if (empty($cou)) {
                                                $cou = "0";
                                            }
                                            //var_dump($cou);
                                            ?>
                                                <tr>
                                                    <td><input type="checkbox" name="id" value="<?php echo $part['id'] ?>"/></td>
                                                    <td><?php echo $part['id'] ?></td>
                                                    <td><?php echo $part['pname'] ?></td>
                                                    <td><?php $sql = "select * from bbs_user where id=" . $part['padmins'];
                                                        $rowpadmins = mysql_func($sql);
                                                        echo $rowpadmins['0']['username'] ?></td>
                                                    <td><?php echo $cou ?></td>
                                                    <td><a href="mod.phpid=<?php echo $part['id'] ?>">编辑</a>
                                                        <a href="del.phpid=<?php echo $part['id'] ?>&zd=id&table=part">删除</a>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-8">
                        <div class="dataTables_info" id="datatable_info" role="status" aria-live="polite">Showing 1
                            to
                            10 of 57 entries
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="dataTables_paginate paging_simple_numbers" id="datatable_paginate">
                            <ul class="pagination">
                                <li class="paginate_button previous disabled" aria-controls="datatable" tabindex="0"
                                    id="datatable_previous"><a href="#">Previous</a></li>
                                <li class="paginate_button active" aria-controls="datatable" tabindex="0"><a
                                            href="#">1</a></li>
                                <li class="paginate_button " aria-controls="datatable" tabindex="0"><a
                                            href="#">2</a>
                                </li>
                                <li class="paginate_button " aria-controls="datatable" tabindex="0"><a
                                            href="#">3</a>
                                </li>
                                <li class="paginate_button next" aria-controls="datatable" tabindex="0"
                                    id="datatable_next"><a href="#">Next</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

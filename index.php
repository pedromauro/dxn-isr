<!DOCTYPE html>
<html>

<head>
    <title></title>
    <?php require_once 'scripts.php'; ?>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card text-center">
                    <div class="card-header">
                        DXN MÉXICO
                    </div>
                    <div class="card-body">
                        <div id="tablaDatatable"> </div>
                    </div>
                    <div class="card-footer text-muted">
                        SOFTBOT
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<script type="text/javascript">
    $(document).ready(function(){
        $('#iddataTable').load('load.php');
    })
</script>
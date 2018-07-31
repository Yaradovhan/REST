<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"
          integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
</head>
<body>
<table class="table table-striped table-dark">
    <thead>
    <tr>
        <th scope="col"><h2>TYPE QUERY</h2></th>
        <th scope="col"><h2>QUERY</h2></th>
        <th scope="col"><h2>PARAMS</h2></th>

    </tr>
    </thead>
    <tbody>
    <tr>
        <th scope="row">INSERT</th>
        <td><?php echo $queryIns;?></td>
        <td><?php  foreach ($dataIns as $k=>$val){ echo $k." = ".$val."<br>";};?></td>
    </tr>
    <tr>
        <th scope="row">SELECT</th>
        <td><?php echo $querySel;?></td>
        <td><?php  foreach ($dataSel as $k=>$val){ echo $k." = ".$val."<br>";};?></td>

    </tr>
    <tr>
        <th scope="row">UPDATE</th>
        <td><?php echo $queryUp;?></td>
        <td><?php  foreach ($dataUp as $k=>$val){ echo $k." = ".$val."<br>";};?></td>

    </tr>
    <tr>
        <th scope="row">DELETE</th>
        <td><?php echo $queryDel;?></td>
        <td><?php  foreach ($dataDel as $k=>$val){ echo $k." = ".$val."<br>";};?></td>
    </tr>
    </tbody>
</table>

</body>
</html>
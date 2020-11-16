<?php
$sl = 1;
foreach ($data as $row) {
    ?>

    <tr>
        <td><?php echo $sl;
    $sl++; ?> </td>
        <td>{{ $row->division_name }}</td>
        <td><?php
            if ($row->status == '0') {
                echo "Inactive";
            } else if ($row->status == '1') {
                echo "Active";
            }
            ?></td>
        <td><a href="#" onclick="getbyId('<?php echo $row->division_id ?>')">Edit</a></td>


    </tr>
    <?php
}
?>

<tr>
    <td colspan="4" align="center">
        {!! $data->links() !!}
    </td>
</tr>

<?php
$sl = 1;
foreach ($data as $row) {
    ?>
<tr>
    <td><?php echo $sl; $sl++; ?> </td>
    <td>{{ $row->company }}</td>
    <td>{{ $row->name }}</td>
    <td>{{ $row->mobile }}</td>
    <td>
    <?php
            if ($row->role_id == '1') {
                echo "Admin";
            } else if ($row->role_id == '2') {
                echo "<b style='color: green; font-weight: bold;'>Seller</b>";
            }else if ($row->role_id == '3') {
                    echo "Customer";
                }
            ?>
    </td>
    <td><?php
            if ($row->status == '0') {
                echo "Inactive";
            } else if ($row->status == '1') {
                echo "Active";
            }
            ?></td>
    <td><a href="#" onclick="getbyId('<?php echo $row->user_id ?>')">Edit</a> ||
    <a href="#" onclick="changesPass('<?php echo $row->user_id ?>')">Change Pass</a>  
    
    </td>
</tr>
<?php
}
?>
<tr>
    <td colspan="4" align="center">
        {!! $data->links() !!}
    </td>
</tr>
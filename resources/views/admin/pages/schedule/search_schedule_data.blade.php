<?php
$sl = 1;
foreach ($data as $row) {
    ?>
<tr>
    <td><?php echo $sl;
    $sl++; ?> </td>
    <td>{{ $row->doctorId }}</td>
    <td><?php
            if ($row->status == '0') {
                echo "Inactive";
            } else if ($row->status == '1') {
                echo "Active";
            }
            ?></td>
    <td><a href="{{url('/admin/find-schedule/'.$row->doctorId)}}" onclick="ConfirmDialog()">Details/Edit</a></td>


</tr>
<?php
}
?>

<tr>
    <td colspan="4" align="center">
        {!! $data->links() !!}
    </td>
</tr>

<script>
    function ConfirmDialog() {
        var x = confirm("Are you sure to edit record?")
        if (x) {
            return true;
        } else {
            return false;
        }
    }
</script>
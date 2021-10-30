<template>
    <div>
        <table class="table table-hover table-bordered" id="dt-contacts">
            <thead>
            <tr>
                <th v-for="header in headers" :key="header.id">{{ header }}</th>
            </tr>
            </thead>
        </table>
    </div>
</template>

<script>
import 'jquery/dist/jquery.min.js';
import "datatables.net-dt/js/dataTables.dataTables";
import "datatables.net-buttons/js/buttons.colVis.js";
import "datatables.net-buttons/js/buttons.html5.js";
import "datatables.net-buttons/js/buttons.print.js";
import $ from 'jquery';

export default {
    name  : "Datatable",
    props : ['url', 'columns', 'headers'],
    mounted() {
        let datatable = $('#dt-contacts').on('processing.dt', function (e, settings, processing) {
            if (processing) {
                $('table').addClass('opacity-25');
            } else {
                $('table').removeClass('opacity-25');
            }
        }).DataTable({
            serverSide      : true,
            processing      : true,
            ajax            : {
                url : this.url,
            },
            columns         : this.columns,
            "fnRowCallback" : function (nRow, aData, iDisplayIndex) {
                $("td:nth-child(1)", nRow).html(iDisplayIndex + 1);
                return nRow;
            },
            lengthChange    : false,
            dom             : 'Blfrtip',
            buttons         : ['csv', 'excel', 'pdf', 'print'],
        });

    },
}
</script>

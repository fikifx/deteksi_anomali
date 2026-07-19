<table>
    <thead>
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        <tr>
            <th rowspan="3">Status Umur Tanaman</th>
            <th rowspan="3">Item Kerja</th>
            <th colspan="9" style="text-align: center;">Topografi </th>
        </tr>
        <tr>
            <th colspan="3" style="text-align: center;">Datar</th>
            <th colspan="3" style="text-align: center;">Roling 1</th>
            <th colspan="3" style="text-align: center;">Roling 2 / Rendahan</th>
        </tr>
        <tr>
            <th>Norma<br>(Hk/Ha)</th>
            <th>Rotasi<br>Kerja</th>
            <th>N x R<br>(Hk/Ha)</th>
            <th>Norma<br>(Hk/Ha)</th>
            <th>Rotasi<br>Kerja</th>
            <th>N x R<br>(Hk/Ha)</th>
            <th>Norma<br>(Hk/Ha)</th>
            <th>Rotasi<br>Kerja</th>
            <th>N x R<br>(Hk/Ha)</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $row)
        <tr>
            <td>{{ $row->status_umur_tanaman }}</td>
            <td>{{ $row->item_kerja }}</td>
            <td>{{ $row->datar_norma }}</td>
            <td>{{ $row->datar_rotasi }}</td>
            <td>{{ $row->datar_nxr }}</td>
            <td>{{ $row->roling1_norma }}</td>
            <td>{{ $row->roling1_rotasi }}</td>
            <td>{{ $row->roling1_nxr }}</td>
            <td>{{ $row->roling2_norma }}</td>
            <td>{{ $row->roling2_rotasi }}</td>
            <td>{{ $row->roling2_nxr }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

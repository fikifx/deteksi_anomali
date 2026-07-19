<table>
    <thead>
        <tr>
            <th>SITECODE</th>
            <th>TDATE</th>
            <th>AFDCODE</th>
            <th>LOCATION</th>
            <th>PLANTINGDATE</th>
            <th>JOBTYPE</th>
            <th>JOBTYPEDESC</th>
            <th>TYPE</th>
            <th>JOBGROUPCODE</th>
            <th>JOBCODE</th>
            <th>JOBDESC</th>
            <th>UOM</th>
            <th>UMP</th>
            <th>HECTPLANTED</th>
            <th>MANDAYS_HI</th>
            <th>MANDAYS_SHI</th>
            <th>HK_PER_HA_HI</th>
            <th>HK_PER_HA_SHI</th>
            <th>PRODUKSI_HI</th>
            <th>PRODUKSI_SHI</th>
            <th>COST_HI</th>
            <th>COST_SHI</th>
            <th>PREMI_HI</th>
            <th>PREMI_SHI</th>
            <th>ADDCOST_HI</th>
            <th>ADDCOST_SHI</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $row)
        <tr>
            <td>{{ $row->sitecode }}</td>
            <td>{{ $row->tdate }}</td>
            <td>{{ $row->afdcode }}</td>
            <td>{{ $row->location }}</td>
            <td>{{ $row->plantingdate }}</td>
            <td>{{ $row->jobtype }}</td>
            <td>{{ $row->jobtypedesc }}</td>
            <td>{{ $row->type }}</td>
            <td>{{ $row->jobgroupcode }}</td>
            <td>{{ $row->jobcode }}</td>
            <td>{{ $row->jobdesc }}</td>
            <td>{{ $row->uom }}</td>
            <td>{{ $row->ump }}</td>
            <td>{{ $row->hectplanted }}</td>
            <td>{{ $row->mandays_hi }}</td>
            <td>{{ $row->mandays_shi }}</td>
            <td>{{ $row->hk_per_ha_hi }}</td>
            <td>{{ $row->hk_per_ha_shi }}</td>
            <td>{{ $row->produksi_hi }}</td>
            <td>{{ $row->produksi_shi }}</td>
            <td>{{ $row->cost_hi }}</td>
            <td>{{ $row->cost_shi }}</td>
            <td>{{ $row->premi_hi }}</td>
            <td>{{ $row->premi_shi }}</td>
            <td>{{ $row->addcost_hi }}</td>
            <td>{{ $row->addcost_shi }}</td>
        </tr>
        @endforeach
    </tbody>
</table>



    <table>
        <tr>
            <th></th>
            <th colspan="13"
                style="color: #000000;font-weight:bolder;vertical-align:center;text-align:center;font-size:20pt;">FORMULIR KRITERIA AUDIT</th>
        </tr>
        <tr>
            <th></th>
        </tr>
    </table>
    <table>
        <tr style="border: 1px;border-color: #0000;">
            <th></th>
            <th rowspan="2" colspan="4" 
                style="background-color: #198754;color: #ffffff;vertical-align: center;font-size: 11pt;font-weight:bold;text-align: center; border: 1px solid #000; border-right: none;">
                KRITERIA</th>
            <th rowspan="2"
                style="word-wrap: break-word; background-color: #198754;color: #ffffff;vertical-align: center;font-size: 11pt;font-weight:bold;text-align: center; border: 1px solid #000;border-right: none;">
                Nilai Elemen %
            <th rowspan="2"
                style="word-wrap: break-word; background-color: #198754;color: #ffffff;vertical-align: center;font-size: 11pt;font-weight:bold;text-align: center; border: 1px solid #000; border-right: none;">
                Nilai Sub Elemen</th>
            <th rowspan="2"
                style="word-wrap: break-word; background-color: #198754;color: #ffffff;vertical-align: center;font-size: 11pt;font-weight:bold;text-align: center; border: 1px solid #000; border-right: none;">
                Nilai Sub sub Elemen</th>
            <th colspan="4"
                style="word-wrap: break-word; background-color: #198754;color: #ffffff;vertical-align: center;font-size: 11pt;font-weight:bold;text-align: center; border: 1px solid #000; border-right: none;">
                Nilai Audit</th>
            <th rowspan="2" 
                style="word-wrap: break-word; background-color: #198754;color: #ffffff;vertical-align: center;font-size: 11pt;font-weight:bold;text-align: center; border: 1px solid #000; width: 200px">
                KETERANGAN</th>
        </tr>
        <tr style="border: 1px;border-color: #0000;">
            <th></th>
            <th
                style="word-wrap: break-word; background-color: #198754;color: #ffffff;vertical-align: center;font-size: 11pt;font-weight:bold;text-align: center; border: 1px solid #000; border-right: none;">
                Nilai Sub Elemen</th>
            <th
                style="word-wrap: break-word; background-color: #198754;color: #ffffff;vertical-align: center;font-size: 11pt;font-weight:bold;text-align: center; border: 1px solid #000; border-right: none;">
                Nilai sub sub elemen</th>
            <th
                style="word-wrap: break-word; background-color: #198754;color: #ffffff;vertical-align: center;font-size: 11pt;font-weight:bold;text-align: center; border: 1px solid #000; border-right: none;">
                Total Nilai Elemen</th>
            <th
                style="word-wrap: break-word; background-color: #198754;color: #ffffff;vertical-align: center;font-size: 11pt;font-weight:bold;text-align: center; border: 1px solid #000; border-right: none;">
                Presentase Nilai Elemen</th>
        </tr>
        <!-- <tr>
            <td></td>
            <td style="word-wrap: break-word; width: 50px; vertical-align: center;font-size: 11pt; font-weight:bold; text-align: center; border: 1px solid #000; border-right: none;">
                I
            </td>
            <td style="word-wrap: break-word; width: 50px; vertical-align: center;font-size: 11pt; font-weight:bold; text-align: center; border: 1px solid #000; border-right: none;">
                sdsdsd
            </td>
            <td style="word-wrap: break-word; width: 50px; vertical-align: center;font-size: 11pt; font-weight:bold; text-align: center; border: 1px solid #000; border-right: none;">
                sdsdsd
            </td>
            <td style="word-wrap: break-word; width: 340px; vertical-align: center;font-size: 11pt; font-weight:bold; text-align: center; border: 1px solid #000; border-right: none;">
                sdsdsd
            </td>
        </tr> -->
        @php
            $critical = 0;
            $mayor = 0;
            $minor = 0;
        @endphp

        @foreach($audit->criteria_module->criteria as $criteria)
            @php 
                $criteria_max_point = 0;
                $criteria_point = 0;
            @endphp

            @foreach($criteria->all_sub_criteria as $subCriteria)
                @php
                    $sub_criteria_max_point = 0;
                    $sub_criteria_point = 0;
                @endphp

                @if($subCriteria->children()->exists())
                    @foreach($subCriteria->children as $subSubCriteria)
                        @php 
                            if($subSubCriteria->excluded == false) {
                                $sub_sub_criteria_max_point = $subSubCriteria->target_point;
                                $sub_sub_criteria_point = $subSubCriteria->point;

                                $sub_criteria_max_point = $sub_criteria_max_point + $sub_sub_criteria_max_point;
                                $sub_criteria_point = $sub_criteria_point + $sub_sub_criteria_point;
                            }
                        @endphp
                    @endforeach                                            
                @else
                    @php
                        if($subCriteria->excluded == false) {
                            $sub_criteria_max_point = $subCriteria->target_point;
                            $sub_criteria_point = $subCriteria->point;
                        }
                    @endphp
                @endif

                @php
                    $criteria_max_point = $criteria_max_point + $sub_criteria_max_point;
                    $criteria_point = $criteria_point + $sub_criteria_point;
                @endphp
            @endforeach
            <tr>
                <td></td>
                <td style="word-wrap: break-word; width: 50px; vertical-align: top;font-size: 11pt; font-weight:bold; border: 1px solid #000; border-right: none; text-align: center;"
                    rowspan="{{($criteria->all_elements()->count()+1)}}">
                    @if($audit->audit_category == 'SMK3')
                        {{$loop->index+1}}
                    @elseif ($audit->audit_category == 'SMKP')
                        {{number2roman($loop->index+1)}}
                    @endif
                </td>
                <td colspan="3" style="word-wrap: break-word; width: 440px; vertical-align: top;font-size: 11pt; font-weight:bold; border: 1px solid #000; border-right: none;">
                    {{substr(strstr($criteria->title," "), 1)}}
                </td>

                <!--  -->

                <td style="word-wrap: break-word; vertical-align: top;font-size: 11pt; font-weight:bold; border: 1px solid #000; border-right: none; text-align: center;">
                    {{$criteria->element_value}}%
                </td>
                <td style="word-wrap: break-word; vertical-align: top;font-size: 11pt; font-weight:bold; border: 1px solid #000; border-right: none; text-align: center;">
                    {{$criteria_max_point}}
                </td>
                <td style="word-wrap: break-word; vertical-align: top;font-size: 11pt; font-weight:bold; border: 1px solid #000; border-right: none; text-align: center;">
                    
                </td>
                <td style="word-wrap: break-word; vertical-align: top;font-size: 11pt; font-weight:bold; border: 1px solid #000; border-right: none; text-align: center;">
                    
                </td>
                <td style="word-wrap: break-word; vertical-align: top;font-size: 11pt; font-weight:bold; border: 1px solid #000; border-right: none; text-align: center;">
                    
                </td>
                <td style="word-wrap: break-word; vertical-align: top;font-size: 11pt; font-weight:bold; border: 1px solid #000; border-right: none; text-align: center;">
                    {{$criteria_point}}
                </td>
                <td style="word-wrap: break-word; vertical-align: top;font-size: 11pt; font-weight:bold; border: 1px solid #000; border-right: none; text-align: center;">
                    {{round($criteria_point/$criteria_max_point*100/$criteria->element_value, 2)}}%
                </td>
                <td style="word-wrap: break-word; vertical-align: top;font-size: 11pt; font-weight:bold; border: 1px solid #000;">
                    
                </td>
            </tr>
            @foreach($criteria->all_sub_criteria as $subCriteria)
                <tr>
                    <td></td>
                    <td style="word-wrap: break-word; width: 50px; vertical-align: top;font-size: 11pt; font-weight:bold; border: 1px solid #000; border-right: none; text-align: center;"
                        rowspan="{{$subCriteria->all_children->count()+1}}">
                        {{strstr($subCriteria->title," ",1)}}
                    </td>
                    <td colspan="2" style="word-wrap: break-word; vertical-align: top;font-size: 11pt; font-weight:bold; border: 1px solid #000; border-right: none;">
                        {{strstr($subCriteria->title," ")}}
                    </td>

                    <!--  -->

                    <td style="word-wrap: break-word; vertical-align: top;font-size: 11pt; font-weight:bold; border: 1px solid #000; border-right: none; text-align: center;">
                    
                    </td>
                    <td style="word-wrap: break-word; vertical-align: top;font-size: 11pt; font-weight:bold; border: 1px solid #000; border-right: none; text-align: center;">
                        @if($subCriteria->children()->exists())
                            {{$subCriteria->children()->sum('max_point') ?? '-' }}
                        @else
                            @if($subCriteria->excluded == true)
                                N/A
                            @else
                                {{$subCriteria->max_point ?? '-' }}
                            @endif
                        @endif
                    </td>
                    <td style="word-wrap: break-word; vertical-align: top;font-size: 11pt; font-weight:bold; border: 1px solid #000; border-right: none; text-align: center;">
                        
                    </td>
                    <td style="word-wrap: break-word; vertical-align: top;font-size: 11pt; font-weight:bold; border: 1px solid #000; border-right: none; text-align: center;">
                        @if($subCriteria->children()->exists())
                            {{$subCriteria->children()->where('point', '!=', null)->count() > 0 ? $subCriteria->children()->sum('point') : '-'}}
                        @else
                            @if($subCriteria->excluded == true)
                                N/A
                            @else
                                {{$subCriteria->point ?? '-'}}
                            @endif
                        @endif
                    </td>
                    <td style="word-wrap: break-word; vertical-align: top;font-size: 11pt; font-weight:bold; border: 1px solid #000; border-right: none; text-align: center;">
                        
                    </td>
                    <td style="word-wrap: break-word; vertical-align: top;font-size: 11pt; font-weight:bold; border: 1px solid #000; border-right: none; text-align: center;">
                        
                    </td>
                    <td style="word-wrap: break-word; vertical-align: top;font-size: 11pt; font-weight:bold; border: 1px solid #000; border-right: none; text-align: center;">
                        
                    </td>
                    <td style="word-wrap: break-word; vertical-align: top; text-align:center; font-size: 11pt; font-weight:bold; border: 1px solid #000;">
                        @if($subCriteria->children()->exists())
                            @if($subCriteria->children()->where('point', '!=', null)->count() > 0)
                                @if($subCriteria->children()->where('is_critical', 1)->count() > 0)
                                    Kritikal 
                                    @php $critical++ @endphp
                                @elseif($subCriteria->children()->sum('point') == $subCriteria->children()->sum('max_point'))

                                @else
                                    @if($subCriteria->children()->sum('point')/$subCriteria->children()->sum('max_point')*100 > 50)
                                        Minor
                                        @php $minor++ @endphp
                                    @else
                                        Mayor
                                        @php $mayor++ @endphp
                                    @endif
                                @endif
                            @else
                                
                            @endif
                        @else
                            @if($subCriteria->is_critical == 1)
                                Kritikal 
                                @php $critical++ @endphp
                            @elseif($subCriteria->point != null)
                                @if($subCriteria->point == $subCriteria->max_point)
                                    
                                @elseif($subCriteria->point/$subCriteria->max_point*100 < 50)
                                    Mayor 
                                    @php $mayor++ @endphp
                                @else
                                    @if($subCriteria->locations->count() > 0)
                                        @if($subCriteria->locations()->where('status', 'non confirmance')->count() / $subCriteria->locations->count() * 100 > 30)
                                            Mayor
                                            @php $mayor++ @endphp
                                        @else
                                            Minor
                                            @php $minor++ @endphp
                                        @endif
                                    @else
                                        Minor
                                        @php $minor++ @endphp
                                    @endif
                                @endif
                            @endif
                        @endif
                    </td>
                </tr>
                @foreach($subCriteria->all_children as $child)
                    <tr>
                        <td></td>
                        <td style="word-wrap: break-word; width: 50px; vertical-align: top;font-size: 11pt; font-weight:bold; border: 1px solid #000; border-right: none; text-align: center;">
                            {{strstr($child->title," ",1)}}
                        </td>
                        <td style="word-wrap: break-word; width: 340px; vertical-align: top;font-size: 11pt; font-weight:bold; border: 1px solid #000; border-right: none;">
                            {{strstr($child->title," ")}}
                        </td>

                        <!--  -->

                        <td style="word-wrap: break-word; vertical-align: top;font-size: 11pt; font-weight:bold; border: 1px solid #000; border-right: none; text-align: center;">
                    
                        </td>
                        <td style="word-wrap: break-word; vertical-align: top;font-size: 11pt; font-weight:bold; border: 1px solid #000; border-right: none; text-align: center;">
                            
                        </td>
                        <td style="word-wrap: break-word; vertical-align: top;font-size: 11pt; font-weight:bold; border: 1px solid #000; border-right: none; text-align: center;">
                            @if($child->excluded == true)
                                N/A
                            @else
                                {{$child->max_point ?? '-'}}
                            @endif
                        </td>
                        <td style="word-wrap: break-word; vertical-align: top;font-size: 11pt; font-weight:bold; border: 1px solid #000; border-right: none; text-align: center;">
                            
                        </td>
                        <td style="word-wrap: break-word; vertical-align: top;font-size: 11pt; font-weight:bold; border: 1px solid #000; border-right: none; text-align: center;">
                            @if($child->excluded == true)
                                N/A
                            @else
                                {{$child->point ?? '-'}}
                            @endif
                        </td>
                        <td style="word-wrap: break-word; vertical-align: top;font-size: 11pt; font-weight:bold; border: 1px solid #000; border-right: none; text-align: center;">
                            
                        </td>
                        <td style="word-wrap: break-word; vertical-align: top;font-size: 11pt; font-weight:bold; border: 1px solid #000; border-right: none; text-align: center;">
                            
                        </td>
                        <td style="word-wrap: break-word; vertical-align: top; font-size: 11pt; font-weight:bold; border: 1px solid #000;">
                            
                        </td>
                    </tr>
                @endforeach
            @endforeach
        @endforeach
    </table>

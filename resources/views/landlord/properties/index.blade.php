@extends('layouts.landlord_layout')

@section('content')

    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">{{ __('Properties')}}</h3>
                            </div><!-- .nk-block-head-content -->
                            <div class="nk-block-head-content">
                                <div class="toggle-wrap nk-block-tools-toggle">
                                    <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1"
                                       data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                                    <div class="toggle-expand-content" data-content="pageMenu">

                                    </div>
                                </div><!-- .toggle-wrap -->
                            </div><!-- .nk-block-head-content -->
                        </div><!-- .nk-block-between -->
                    </div><!-- .nk-block-head -->


                    <div class="nk-block">
                        <div class="card card-bordered card-preview">
                            <div class="card-inner">

                                <div class="row g-1">
                                    <div class="col-md-3">
                                        <div class="form-group">

                                            <div class="form-control-wrap ">
                                                <div class="form-control-select">
                                                    <select class="form-control" id="property-status-filter">
                                                        <option value="">{{ __('Filter Status')}}</option>
                                                        <option
                                                            value="{{ \App\Enums\PropertyStatusEnum::MULTI_UNIT->value }}">
                                                            {{ __('Multi Units')}}
                                                        </option>
                                                        <option
                                                            value="{{ \App\Enums\PropertyStatusEnum::UNDER_MAINTENANCE->value }}">
                                                            {{ __('Under Maintenance')}}
                                                        </option>
                                                        <option
                                                            value="{{ \App\Enums\PropertyStatusEnum::OCCUPIED->value }}">
                                                           {{ __(' Occupied(Single Unit)')}}
                                                        </option>
                                                        <option
                                                            value="{{ \App\Enums\PropertyStatusEnum::VACANT->value }}">
                                                            {{ __('Vacant(Single Unit)')}}
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-3 ms-auto">
                                        <div class="form-group">

                                            <div class="form-control-wrap ">
                                                <input type="search" class="form-control" id="search-input"
                                                       placeholder="{{ __('Type in to search')}}">
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <table class="datatable table dt-responsive nowrap nk-tb-list nk-tb-ulist is-compact"
                                       id="tenants-list">

                                    {{--                                <table class="datatable nowrap" id="tenants-list">--}}
                                    <thead>
                                    <tr class="nk-tb-item nk-tb-head">
                                        <th data-priority="2" class="nk-tb-col nk-tb-col-check">
                                            #
                                        </th>
                                        <th data-priority="1" class="nk-tb-col">
                                            <span class="sub-text">{{ __('Name')}}</span>
                                        </th>
                                        <th class="nk-tb-col">
                                            <span class="sub-text">{{ __('Type')}}</span>
                                        </th>
                                        <th class="nk-tb-col">
                                            <span class="sub-text">{{ __('Address')}}</span>
                                        </th>
                                        <th>
                                            {{ __('City')}}
                                        </th>
                                        <th class="nk-tb-col">
                                            <span
                                                class="sub-text">{{ __('Status')}}</span>
                                        </th>

                                        <th class="nk-tb-col">
                                            {{ __('Details')}}
                                        </th>

                                    </tr>
                                    </thead>
                                    <tbody>


                                    </tbody>
                                </table>
                            </div>
                        </div><!-- .card-preview -->
                    </div><!-- .nk-block -->
                </div>
            </div>
        </div>
    </div>


@endsection

@push('scripts')

    <script>
        $(document).ready(function () {
            const dom_normal = '<"row justify-between g-2"<"col-7 col-sm-4 text-start"><"col-5 col-sm-8 text-end"<"datatable-filter"<"d-flex justify-content-end g-2"l>>>><"datatable-wrap my-3"t><"row align-items-center"<"col-7 col-sm-12 col-md-9"p><"col-5 col-sm-12 col-md-3 text-start text-md-end"i>>';

            var oTable = $("#tenants-list").DataTable(
                {
                    processing: true,
                    serverSide: true,
                    dom: dom_normal,
                    "bInfo": true,
                    "bLengthChange": false,
                    // 'searching': false,
                    ajax: {
                        url: '{!! route('landlord.properties.index') !!}',
                        data: function (d) {
                            d.status_filter = $("#property-status-filter").val();
                        }
                    },
                    autoWidth: false,
                    responsive: {
                        details: {
                            renderer: function (api, rowIdx) {

                                var data = api.cells(rowIdx, ':hidden').eq(0).map(function (cell) {
                                    var header = $(api.column(cell.column).header());

                                    return '<tr>' +
                                        '<td class="fw-bold">' +
                                        header.text() + ':' +
                                        '</td> ' +
                                        '<td>' +
                                        api.cell(cell).data() +
                                        '</td>' +
                                        '</tr>';
                                }).toArray().join('');

                                return data ?
                                    $('<table/>').append(data) :
                                    false;
                            },

                        }
                    },

                    language: {
                        search: "",
                        searchPlaceholder: "Type in to Search",
                        lengthMenu: "<span class='d-none d-sm-inline-block'>Show</span><div class='form-control-select'> _MENU_ </div>",
                        info: "_START_ -_END_ of _TOTAL_",
                        infoEmpty: "0",
                        infoFiltered: "( Total _MAX_  )",
                        paginate: {
                            "first": "First",
                            "last": "Last",
                            "next": "Next",
                            "previous": "Prev"
                        }
                    },

                    createdRow: function (row, data, dataIndex) {
                        $(row).find('td:eq(0)').addClass('nk-tb-col');
                        $(row).find('td:eq(1)').addClass('nk-tb-col');
                        $(row).find('td:eq(2)').addClass('nk-tb-col');
                        $(row).find('td:eq(3)').addClass('nk-tb-col');
                        $(row).find('td:eq(4)').addClass('nk-tb-col');
                        $(row).find('td:eq(5)').addClass('nk-tb-col');
                        // $(row).find('td:eq(5)').addClass('nk-tb-col');
                        // $(row).find('td:eq(6)').addClass('nk-tb-col');
                    },
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                        {data: 'name', name: 'name', searchable: true},
                        {data: 'type', name: 'type', searchable: true},
                        {data: 'address', name: 'address.city', searchable: true},
                        {data: 'address', name: 'address.state', searchable: true, visible: false},
                        {data: 'status', name: 'status', searchable: false, orderable: false},
                        {data: 'details', name: 'details', searchable: false, orderable: false},
                    ],
                    drawCallback: function () {
                        $(".dataTables_paginate > .pagination").addClass("mt-3")
                    }
                });

            // $('#search-input').keyup(function(){
            //     oTable.search($(this).val()).draw() ;
            // })

            $('#search-input').on('input', function () {
                oTable.search($(this).val()).draw();
            });

            $('#property-status-filter').on('change', function () {
                oTable.ajax.reload(null, false);
            });

        });
    </script>


@endpush

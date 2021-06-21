@extends('layouts.admin')
@section('content')
@can('servicecost_create')

@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.servicecost.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Servicecost">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.servicecost.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.servicecost.fields.site') }}
                        </th>
                        <th>
                            {{ trans('cruds.servicecost.fields.service') }}
                        </th>

                        <th>
                            {{ trans('cruds.servicecost.fields.cost') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($servicecosts as $key => $servicecost)
                      @if(($servicecost->site->name ?? '') != '' && ($servicecost->service->name ?? '') != '')
                          <tr data-entry-id="{{ $servicecost->id }}">
                              <td>

                              </td>
                              <td>
                                  {{ $servicecost->id ?? '' }}
                              </td>
                              <td>
                                  {{ $servicecost->site->name ?? '' }}
                              </td>
                              <td>
                                  {{ $servicecost->service->name ?? '' }}
                              </td>
                              <td>
                                  {{ $servicecost->cost ?? '' }}
                              </td>
                              <td>
                                  @can('servicecost_show')
                                      <a class="btn btn-xs btn-primary" href="{{ route('admin.servicecosts.show', $servicecost->id) }}">
                                          {{ trans('global.view') }}
                                      </a>
                                  @endcan

                                  @can('servicecost_edit')
                                      <a class="btn btn-xs btn-info" href="{{ route('admin.servicecosts.edit', $servicecost->id) }}">
                                          {{ trans('global.edit') }}
                                      </a>
                                  @endcan

                                  @can('servicecost_delete')
                                      <form action="{{ route('admin.servicecosts.destroy', $servicecost->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                          <input type="hidden" name="_method" value="DELETE">
                                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                          <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                      </form>
                                  @endcan

                              </td>

                          </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>


    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('servicecost_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.servicecosts.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  $('.datatable-Servicecost:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection

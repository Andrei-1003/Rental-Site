@include('dashboard.components.header')
<div id="wrapper">
    @include('dashboard.components.top-bar')
    @include('dashboard.components.nav')
    <div class="content-page">
        <div class="content">
            @include('dashboard.components.breadcrumb', ['heading' => __('Home Type')])
            {{--Start Content--}}
            <?php
            $search = request()->get('_s');
            $order = request()->get('order', 'asc');
            ?>
            <div class="card-box">
                <div class="header-area d-flex align-items-center">
                    <h4 class="header-title mb-0">{{__('All Types')}}</h4>
                    <form class="form-inline right d-none d-sm-block" method="get">
                        <div class="form-group">
                            <input type="text" class="form-control" name="_s"
                                   value="{{ $search }}"
                                   placeholder="{{__('Search id, name')}}">
                        </div>
                        <button type="submit" class="btn btn-default"><i class="ti-search"></i></button>
                    </form>
                </div>
                <?php
                enqueue_style('datatables-css');
                enqueue_script('datatables-js');
                enqueue_script('pdfmake-js');
                enqueue_script('vfs-fonts-js');
                ?>
                <table class="table table-large mb-0 dt-responsive nowrap w-100" data-plugin="datatable"
                       data-paging="false"
                       data-ordering="false">
                    <thead>
                    <tr>
                        <th data-priority="1">
                            {{__('ID')}}
                        </th>
                        <th data-priority="1" class="force-show">
                            {{__('Name')}}
                        </th>
                        <th data-priority="3">
                            {{__('Description')}}
                        </th>
                        <th data-priority="-1" class="text-center">{{__('Actions')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if ($allTerms['total'])
                        @foreach ($allTerms['results'] as $item)
                            <?php
                            $imageID = $item->term_image;
                            ?>
                            <tr>
                                <td class="align-middle">
                                    {{$item->term_id}}
                                </td>
                                <td class="align-middle force-show">
                                    <div class="media align-items-center">
                                        @if(!empty($imageID))
                                            <?php $imageUrl = get_attachment_url($imageID); ?>
                                            <img src="{{ $imageUrl }}" class="d-none d-md-block mr-3"
                                                 alt="{{__('Featured Image')}}">
                                        @endif
                                        <div class="media-body">
                                            <h5 class="m-0">
                                                {{ get_translate($item->term_title) }}
                                            </h5>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <p class="mb-0"><i
                                            class="text-muted">{{ get_translate($item->term_description) }}</i>
                                    </p>
                                </td>
                                <td class="align-middle text-center">
                                    <div class="dropdown d-inline-block">
                                        <a href="javascript: void(0)" class="dropdown-toggle table-action-link"
                                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                                class="ti-settings"></i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <?php
                                            $data = [
                                                'termID' => $item->term_id,
                                                'termEncrypt' => hh_encrypt($item->term_id)
                                            ];
                                            ?>
                                            <a href="javascript:void(0)" class="dropdown-item" data-toggle="modal"
                                               data-params="{{ base64_encode(json_encode($data)) }}"
                                               data-target="#hh-update-home-types-modal">{{__('Edit')}}</a>
                                            <a class="dropdown-item hh-link-action hh-link-delete-tax"
                                               data-action="{{ dashboard_url('delete-term-item') }}"
                                               data-parent="tr"
                                               data-is-delete="true"
                                               data-params="{{ base64_encode(json_encode($data)) }}"
                                               href="javascript: void(0)">{{__('Delete')}}</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="3">
                                <h4 class="mt-3 text-center">{{__('No term yet.')}}</h4>
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
                <div class="clearfix">
                    {{ dashboard_pagination(['total' => $allTerms['total']]) }}
                </div>
            </div>
            <div id="hh-update-home-types-modal" class="modal fade hh-get-modal-content" tabindex="-1" role="dialog"
                 aria-hidden="true"
                 data-url="{{ dashboard_url('get-term-item/home-type') }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form class="form form-action form-update-term-modal relative form-translation"
                              data-validation-id="form-update-term"
                              action="{{ dashboard_url('update-term-item') }}">
                            @include('common.loading')
                            <div class="modal-header">
                                <h4 class="modal-title">{{__('Update Home Type')}}</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                                </button>
                            </div>
                            <div class="modal-body">
                            </div>
                            <div class="modal-footer">
                                <button type="submit"
                                        class="btn btn-info waves-effect waves-light">{{__('Update')}}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div><!-- /.modal -->
            {{--End content--}}
            @include('dashboard.components.footer-content')
        </div>
    </div>
</div>
@include('dashboard.components.footer')

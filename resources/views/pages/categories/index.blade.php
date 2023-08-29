<x-base-layout>


    <div class="row g-xxl-9">
        <!--begin::Col-->
        <div class="col-xxl-12">
            <!--begin::Earnings-->
            <div class="d-flex flex-wrap justify-content-between pb-6 bg-green-800">
                <!--begin::Row-->
                <div class="d-flex flex-wrap">
                    <a href="#" class="card hover-elevate-up shadow-sm parent-hover" data-bs-toggle="modal" data-bs-target="#kt_modal_create_category">
                        <div class="card-body d-flex align-items ">
                            <span class="svg-icon svg-icon-1">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor"></rect>
                                    <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor"></rect>
                                </svg>
                            </span>

                            <span class="ms-3 text-gray-700  parent-hover-primary fs-6 fw-bold">
                                Add a new Category
                            </span>
                        </div>
                    </a>
                </div>
                <!--end::Row-->

            </div>
            <!--end::Earnings-->
        </div>
        <!--end::Col-->

    </div>



    <div class="card mb-5 mb-xl-8">

        <!--begin::Body-->
        <div class="card-body py-3">
            <!--begin::Table container-->
            <div class="table-responsive">
                <!--begin::Table-->
                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                    <!--begin::Table head-->
                    <thead>
                        <tr class="fw-bold text-muted">
                            <th class="w-25px">
                                <div class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="1" data-kt-check="true" data-kt-check-target=".widget-9-check" />
                                </div>
                            </th>
                            <th class="min-w-200px">{{ __('Görsel') }}</th>
                            <th class="min-w-200px">{{ __('Kategori Adı') }}</th>
                            <th class="min-w-200px">{{ __('Açıklama') }}</th>
                            <th class="min-w-200px">{{ __('Durum') }}</th>

                            <th class="min-w-100px text-end">{{ __('İşlemler') }}</th>
                        </tr>
                    </thead>
                    <!--end::Table head-->

                    <!--begin::Table body-->
                    <tbody>
                        @foreach ($categories as $category )
                        <tr>
                            <td>
                                <div class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input widget-9-check" type="checkbox" value="1" />
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="d-flex justify-content-start flex-column">
                                      <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" height="50">
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="d-flex justify-content-start flex-column">
                                        <span class="text-muted fw-semibold text-muted d-block fs-7">{{ $category->name }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="d-flex justify-content-start flex-column">
                                        <span class="text-muted fw-semibold text-muted d-block fs-7">{{ Str::limit($category->description, 150) }}</span>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="d-flex justify-content-start flex-column">
                                        <span class="badge badge-{{ $category->status == 'active' ? 'success' : 'danger' }}">{{ ucfirst($category->status) }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex justify-content-end flex-shrink-0">
                                <a href="#" data-id={{ $category->id }} class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 edit">
                                        <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                                        <span class="svg-icon svg-icon-3">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    opacity="0.3"
                                                    d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z"
                                                    fill="currentColor"
                                                ></path>
                                                <path
                                                    d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z"
                                                    fill="currentColor"
                                                ></path>
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </a>
                                    <a href="#" data-id={{ $category->id }} class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm delete">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                        <span class="svg-icon svg-icon-3">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="currentColor"></path>
                                                <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="currentColor"></path>
                                                <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="currentColor"></path>
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <!--end::Table body-->
                </table>
                <!--end::Table-->
            </div>
            <!--end::Table container-->
        </div>
        <!--begin::Body-->
    </div>



    <div class="modal fade" id="kt_modal_create_category" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content rounded">
                <!--begin::Modal header-->
                <div class="modal-header pb-0 border-0 justify-content-end">
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--begin::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
                    <!--begin:Form-->
                    <form id="save_cat" class="form fv-plugins-bootstrap5 fv-plugins-framework" method="POST" enctype="multipart/form-data" action="#">
                        @csrf
                        <!--begin::Heading-->
                        <div class="mb-13 text-center">
                            <!--begin::Title-->
                            <h1 class="mb-3">{{ __('Kategori Oluştur') }}</h1>
                            <!--end::Title-->
                        </div>
                        <!--end::Heading-->
                        <!--begin::Input group-->
                        <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                            <!--begin::Label-->
                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span class="required">{{ __('Kategori Adı') }}</span>
                            </label>
                            <!--end::Label-->
                            <input type="text" class="form-control" placeholder="{{ __('Kategori Adı') }}" id="category_name" name="category_name">
                        <div class="fv-plugins-message-container invalid-feedback"></div></div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="d-flex flex-column mb-8">
                            <label class="fs-6 fw-semibold mb-2">{{ __('Kategori Açıklama') }}</label>
                            <textarea class="form-control" rows="5" name="category_description" id="category_description" placeholder="{{ __('Kategori Açıklama') }}"></textarea>
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                            <!--begin::Label-->
                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span class="">{{ __('Görsel') }}</span>
                            </label>
                            <!--end::Label-->
                            <input type="file" class="form-control" id="image"  name="image">
                            <div class="fv-plugins-message-container invalid-feedback"></div></div>
                        <!--end::Input group-->
                           <!--end::Input group-->
                           <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                            <label class="col-lg-3 col-form-label">{{ __('Status') }}:</label>
                            <div class="col-lg-9">
                                <div class="radio-inline">
                                    <label class="radio radio-solid mr-1 mt-3">
                                        <input class="form-check-input status" type="radio"
                                            name="status" value="active">
                                        {{ __('Active') }}
                                    </label>
                                    <label class="radio radio-solid">
                                        <input class="form-check-input status" type="radio"
                                            name="status" value="inactive">
                                        {{ __('Inactive') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!--begin::Actions-->
                        <div class="text-center">
                            <button type="submit" id="save_category" class="btn btn-primary">
                                <span class="indicator-label">{{ __('Kaydet') }}</span>
                                <span class="indicator-progress">{{ __('Lütfen bekleyiniz...') }}
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>
                        <!--end::Actions-->
                    </form>
                    <!--end:Form-->
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>

    <div class="modal fade" id="kt_modal_update_category" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content rounded">
                <!--begin::Modal header-->
                <div class="modal-header pb-0 border-0 justify-content-end">
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--begin::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
                    <!--begin:Form-->
                    <form id="update_cat" class="form fv-plugins-bootstrap5 fv-plugins-framework" enctype="multipart/form-data" action="#">
                          @csrf
                        <!--begin::Heading-->
                        <div class="mb-13 text-center">
                            <!--begin::Title-->
                            <h1 class="mb-3">{{ __('Kategori Güncelle') }}</h1>
                            <!--end::Title-->
                        </div>
                        <!--end::Heading-->
                        <!--begin::Input group-->
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" id="update_category_id" />
                        <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                            <!--begin::Label-->
                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span class="required">{{ __('Kategori Adı') }}</span>
                            </label>
                            <!--end::Label-->
                            <input type="text" class="form-control" placeholder="{{ __('Kategori Adı') }}" id="cat_name" name="category_name">
                        <div class="fv-plugins-message-container invalid-feedback"></div></div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="d-flex flex-column mb-8">
                            <label class="fs-6 fw-semibold mb-2">{{ __('Kategori Adı') }}</label>
                            <textarea class="form-control" rows="10" name="category_description" id="cat_description" placeholder="{{ __('Kategori Adı') }}"></textarea>
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                            <!--begin::Label-->
                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span class="">{{ __('Görsel') }}</span>
                            </label>
                            <!--end::Label-->
                            <input type="file" class="form-control mb-5" id="cat_image"  name="image">
                            <div id="insertedImages"></div>

                        <div class="fv-plugins-message-container invalid-feedback"></div></div>
                        <!--end::Input group-->
                           <!--end::Input group-->
                           <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                            <label class="col-lg-3 col-form-label">{{ __('Status') }}:</label>
                            <div class="col-lg-9">
                                <div class="radio-inline">
                                    <label class="radio radio-solid mr-1 mt-3">
                                        <input class="form-check-input category_status" type="radio"
                                            name="category_status" value="active">
                                        {{ __('Active') }}
                                    </label>
                                    <label class="radio radio-solid">
                                        <input class="form-check-input category_status" type="radio"
                                            name="category_status" value="inactive">
                                        {{ __('Inactive') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!--begin::Actions-->
                        <div class="text-center">
                            <button type="submit" id="update_category" class="btn btn-primary">
                                <span class="indicator-label">{{ __('Kaydet') }}</span>
                                <span class="indicator-progress">{{ __('lütfen bekleyiniz...') }}
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>
                        <!--end::Actions-->
                    </form>
                    <!--end:Form-->
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>


    <div class="modal fade" id="kt_modal_delete_category" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header pb-0 border-0 justify-content-end">
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--begin::Modal header-->

                <!--begin::Modal body-->
                <div class="modal-body scroll-y mx-5 mx-xl-18 pt-0 pb-15">
                    <!--begin::Heading-->
                    <div class="text-center mb-13">
                        <!--begin::Title-->
                        <h1 class="mb-3">{{ __('Kategori Sil') }}</h1>

                        <!--end::Description-->
                    </div>
                    <!--end::Heading-->

                    <form action="">
                        @csrf
                        <input type="hidden" id="delete_category_id" />
                        <h4 class="text-center">{{ __('Silmek istediğinize emin misiniz??') }}</h4>

                        <div class="text-center pt-10">
                            <button class="btn btn-danger mr-1 delete_category" type="submit">{{ __('Sil') }}</button>
                        </div>
                    </form>



                    <!--end::Notice-->
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>

@section('scripts')
<script type="text/javascript">

   jQuery(document).ready(function($){

    $(".edit").click(function (e) {
             e.preventDefault();
             var category_id = $(this).attr('data-id');

             $('#kt_modal_update_category').modal('show');

             $.ajax({
                type: 'GET',
                url: '/admin/edit-category/'+category_id,
                success : function (response){
                     console.log(response);
                    $('#cat_name').val(response.category.name);
                    $('#cat_description').val(response.category.description);
                    var status = response.category.status;
                            if (status == 'active') {
                                $("input[name=category_status][value=" + status + "]").prop('checked', true);
                            }
                            if (status == 'inactive') {
                                $("input[name=category_status][value=" + status + "]").prop('checked', true);
                            }

                    $('#update_category_id').val(category_id)
                }
        });
    });

    $('#save_category').click(function (e) {
        e.preventDefault();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var file =  $('#image')[0].files[0];

        let formData = new FormData();
        formData.append('image', file);
        formData.append('category_name',$("#category_name").val());
        formData.append('category_description',$("#category_description").val());
        formData.append('status', $(".status:checked").val());

          $.ajax({
              url: '/admin/add-categories',
              method: 'POST',
              data: formData,
              dataType: 'JSON',
              contentType: false,
              processData: false,
              success : function (response){
                Swal.fire({
                    icon: 'success',
                    title: 'Category has been saved!',
                    showConfirmButton: false,
                    timer: 3000
                    });
                    $('#kt_modal_create_category').modal('hide');
                    location.reload();
                }
    });
  });

  $('#update_category').click(function (e) {
        e.preventDefault();
        var category_id = $('#update_category_id').val();

        var file =  $('#cat_image')[0].files[0];

        let formData = new FormData();
        formData.append('image', file);
        formData.append('category_name',$("#cat_name").val());
        formData.append('category_description',$("#cat_description").val());
        formData.append('status', $(".category_status:checked").val());
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
                type: 'POST',
                 url: '/admin/update-category/'+category_id,
                data : formData,
                dataType: "json",
                processData: false,
                contentType: false,
                success : function (response){
                    Swal.fire({
                    icon: 'success',
                    title: 'Category has been updated!',
                    showConfirmButton: false,
                    timer: 2500
                    });
                    $('#kt_modal_update_category').modal('hide');
                    location.reload();
                }
        });

    });

    $(".delete").click(function (e) {
             e.preventDefault();
             var category_id = $(this).attr('data-id');
             $('#delete_category_id').val(category_id);
             $('#kt_modal_delete_category').modal('show');
         });

            $(".delete_category").click(function (e) {
            e.preventDefault();
            var category_id = $('#delete_category_id').val();

             $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'DELETE',
                 url: '/admin/delete-category/'+category_id,
                success : function (response){
                    // console.log(response);
                    Swal.fire({
                    icon: 'success',
                    title: 'Category has been deleted!',
                    showConfirmButton: false,
                    timer: 2500
                    });
                    $('#kt_modal_delete_category').modal('hide');
                    location.reload();
                }
        });
    });
});
</script>
@endsection
</x-base-layout>


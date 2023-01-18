@extends('layouts.app')
@section('side_bar')
@endsection
@section('nav_content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="background: white;font-weight: 700;font-size: large">
            <li class="breadcrumb-item"><a href="">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page"></li>
            <li class="breadcrumb-item active" aria-current="page">Networks</li>
        </ol>
    </nav>
@endsection

@section('content')



                        <div class="col-12" >





                        </div>
@endsection


@push('scripts')
    <script type="application/javascript">
        function changeStatus(e){
            $('#changeActivation_network').val(e['0'].dataset.targetId);
            var form = $('#changeActivation').serializeArray();
            var url = "";
            $.ajax({
                type: "POST",
                data: form,
                dataType: 'form-data',
                url: url,
            });
        }

        function getNetworks() {
            var url = "";
            var governorate = $('#governorate').val();
            var search_text = $('#search_text').val();
            var administrative_division = $('#administrative_division').val();
            var types_billboard = $('#types_billboard').val();

            window.location.href = url+"/"+governorate+"/"+administrative_division+"/"+types_billboard+"/"+search_text;
        }
    </script>
@endpush

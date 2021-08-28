<a class="btn btn-success btn-xs" id="AddNew"><i class="fa fa-plus-circle"></i> Add More</a>
<br/>
<div class="bordered" style="border:1px dashed #000000b8;padding: 10px;">
    <div class="items">
        @foreach($items as $k=>$value)
        <div class="item deb" style="margin: 5px;">
            <a class="btn btn-danger btn-xs del-item " ><i class="fa fa-trash-o"></i> Delete</a>
            <select class="form-control select5 department_id" style="margin-top:20px" name="dep_id[{{$k}}][]" multiple>
            </select>
            <br/>
            <textarea class="form-control editor1" name="item[]" required="">{!!$value->item!!}</textarea>
            <hr style="border-top: 1px dashed #dddddd;"/>
        </div>

        @endforeach
    </div>
</div>
<script>
    $(document).ready(function () {
        $('.editor1').summernote({
            height: 250, // set editor height
            minHeight: null, // set minimum height of editor
            maxHeight: null, // set maximum height of editor

        });

        $('body').on('DOMNodeInserted', 'select.select5', function () {
            $(this).select2();
        });
        //$('.select2').select2()
        $(".department_id").jCombo("{{ URL::to('commitments/comboselect?filter=tb_departments:id:title') }}");
    });

</script>

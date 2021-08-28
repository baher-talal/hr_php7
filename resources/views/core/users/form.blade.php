@extends('layouts.app')

@section('content')

    <div class="page-content row">
        <!-- Page header -->
        <div class="page-header">
            <div class="page-title">
                <h3> {{ $pageTitle }} <small>{{ $pageNote }}</small></h3>
            </div>
            <ul class="breadcrumb">
                <li><a href="{{ URL::to('dashboard') }}">{{ Lang::get('core.home') }}</a></li>
                <li><a href="{{ URL::to('core/users?return=' . $return) }}">{{ $pageTitle }}</a></li>
                <li class="active">{{ Lang::get('core.addedit') }} </li>
            </ul>

        </div>

        <div class="page-content-wrapper m-t">


            <div class="sbox animated fadeInRight">
                <div class="sbox-title">
                    <h4> <i class="fa fa-table"></i> <?php echo $pageTitle; ?>
                        <small>{{ $pageNote }}</small></h4>
                </div>
                <div class="sbox-content">
                    <ul class="parsley-error-list">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>

                    <?php
                    // echo url('core/users/save/') ;
                    ?>
                    {!! Form::open(['url' => 'core/users/save?return=' . $return, 'class' => 'form-horizontal', 'files' => true, 'parsley-validate' => '', 'novalidate' => ' ']) !!}
                    <div class="col-md-6">


                        <div class="form-group hidethis " style="display:none;">
                            <label for="Id" class=" control-label col-md-4 text-left"> Id </label>
                            <div class="col-md-6">
                                {!! Form::text('id', $row['id'], ['class' => 'form-control', 'placeholder' => '']) !!}
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>
                        <div class="form-group  ">
                            <label for="Group / Level" class=" control-label col-md-4 text-left"> Group / Level <span
                                    class="asterix"> * </span></label>
                            <div class="col-md-6">

                                <!--									  <select name='group_id' rows='5' id='group_id' code='{$group_id}'
    class='select2 '  required  ></select> -->

                                {!! Form::select('group_id', $groups, $row['group_id'], ['class' => 'select2']) !!}

                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>



                        <div class="form-group  ">
                            <label for="Department" class=" control-label col-md-4 text-left"> Department <span
                                    class="asterix"> * </span> </label>
                            <div class="col-md-6">

                                <!--									  <select name='group_id' rows='5' id='group_id' code='{$group_id}'
                                                                          class='select2 '  required  ></select> -->

                                {!! Form::select('department_id', $departments, $row['department_id'], ['class' => 'select2', 'required' => 'true']) !!}

                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>




                        <div class="form-group  ">
                            <label for="Per Diem Position" class=" control-label col-md-4 text-left"> Per Diem Position
                                <span class="asterix"> * </span> </label>
                            <div class="col-md-6">

                                {!! Form::select('per_diem_position_id', $Perdiempositions, $row['per_diem_position_id'], ['class' => 'select2', 'required' => 'true']) !!}

                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>


                        <div class="form-group  ">
                            <label for="Username" class=" control-label col-md-4 text-left"> Username <span class="asterix">
                                    * </span></label>
                            <div class="col-md-6">
                                {!! Form::text('username', $row['username'], ['class' => 'form-control', 'placeholder' => '', 'required' => 'true']) !!}
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>


                        <div class="form-group  ">
                            <label for="First Name" class=" control-label col-md-4 text-left"> First Name <span
                                    class="asterix"> * </span></label>
                            <div class="col-md-6">
                                {!! Form::text('first_name', $row['first_name'], ['class' => 'form-control', 'placeholder' => '', 'required' => 'true']) !!}
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>
                        <div class="form-group  ">
                            <label for="Last Name" class=" control-label col-md-4 text-left"> Last Name </label>
                            <div class="col-md-6">
                                {!! Form::text('last_name', $row['last_name'], ['class' => 'form-control', 'placeholder' => '']) !!}
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>
                        <div class="form-group  ">
                            <label for="Email" class=" control-label col-md-4 text-left"> Email <span class="asterix"> *
                                </span></label>
                            <div class="col-md-6">
                                {!! Form::text('email', $row['email'], ['class' => 'form-control', 'placeholder' => '', 'required' => 'true', 'parsley-type' => 'email']) !!}
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>
                        @if (request()->route('id'))
                            @if ($tb_config->enable_annual_input == 1)
                                <div class="form-group  ">
                                    <label for="vacation number" class=" control-label col-md-4 text-left"> Annual credit
                                    </label>
                                    <div class="col-md-6">
                                        {!! Form::text('annual_credit', $row['annual_credit'], ['class' => 'form-control', 'placeholder' => '']) !!}
                                    </div>
                                    <div class="col-md-2">

                                    </div>
                                </div>
                            @endif
                        @else
                            <div class="form-group  ">
                                <label for="vacation number" class=" control-label col-md-4 text-left"> Annual credit
                                </label>
                                <div class="col-md-6">
                                    {!! Form::text('annual_credit', $row['annual_credit'], ['class' => 'form-control', 'placeholder' => '']) !!}
                                </div>
                                <div class="col-md-2">

                                </div>
                            </div>
                        @endif





                        <div class="form-group  ">
                            <label for="vacation number" class=" control-label col-md-4 text-left"> Phone Number </label>
                            <div class="col-md-6">
                                {!! Form::text('phone_number', $row['phone_number'], ['class' => 'form-control', 'placeholder' => '']) !!}
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>

                        <div class="form-group  ">
                            <label for="vacation number" class=" control-label col-md-4 text-left"> Employee Finger Id
                            </label>
                            <div class="col-md-6">
                                {!! Form::text('employee_finger_id', $row['employee_finger_id'], ['class' => 'form-control', 'placeholder' => '']) !!}
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>







                        <div class="form-group  ">
                            <label for="Status" class=" control-label col-md-4 text-left"> Status <span class="asterix"> *
                                </span></label>
                            <div class="col-md-6">

                                <label class='radio radio-inline'>
                                    <input type='radio' name='active' value='0' required @if ($row['active'] == '0') checked="checked" @endif> Inactive </label>
                                <label class='radio radio-inline'>
                                    <input type='radio' name='active' value='1' required @if ($row['active'] == '1') checked="checked" @endif> Active </label>
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>


                        <div class="form-group  ">
                            <label for="Avatar" class=" control-label col-md-4 text-left"> Avatar </label>
                            <div class="col-md-6">
                                <input type='file' name='avatar' id='avatar' @if ($row['avatar'] == '') class='required' @endif
                                    style='width:150px !important;' />
                                <div>
                                    {!! SiteHelpers::showUploadedFile($row['avatar'], '/uploads/users/') !!}

                                </div>

                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>
                    </div>



                    <div class="col-md-6">

                        <div class="form-group">

                            <label for="ipt" class=" control-label col-md-4 text-left"> </label>
                            <div class="col-md-8">
                                @if ($row['id'] != '')
                                    {{ Lang::get('core.notepassword') }}
                                @else
                                    Create Password
                                @endif
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="ipt" class=" control-label col-md-4"> {{ Lang::get('core.newpassword') }}
                            </label>
                            <div class="col-md-8">
                                <input name="password" type="password" id="password" class="form-control input-sm" value=""
                                    @if ($row['id'] == '') required @endif />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="ipt" class=" control-label col-md-4"> {{ Lang::get('core.conewpassword') }}
                            </label>
                            <div class="col-md-8">
                                <input name="password_confirmation" type="password" id="password_confirmation"
                                    class="form-control input-sm" value="" @if ($row['id'] == '') required @endif />
                            </div>
                        </div>



                    </div>


                    <div style="clear:both"></div>


                    <div class="form-group">
                        <label class="col-sm-4 text-right">&nbsp;</label>
                        <div class="col-sm-8">
                            <button type="submit" name="apply" class="btn btn-info btn-sm"><i
                                    class="fa  fa-check-circle"></i> {{ Lang::get('core.sb_apply') }}</button>
                            <button type="submit" name="submit" class="btn btn-primary btn-sm"><i class="fa  fa-save "></i>
                                {{ Lang::get('core.sb_save') }}</button>
                            <button type="button" onclick="location.href ='{{ URL::to('core/users?return=' . $return) }}' "
                                class="btn btn-success btn-sm "><i class="fa  fa-arrow-circle-left "></i>
                                {{ Lang::get('core.sb_cancel') }} </button>
                        </div>

                    </div>

                    {!! Form::close() !!}


                    <!-- reset by sending email
                       <div   class="rest_user_password" >

                         <div class="form-group" >

                           <div class="col-md-6">
                               <form method="post" action="{{ url('user/request') }}" class="" id="fr">
                                   <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                   <div class="form-group has-feedback">
                                       <div class="">
                                           <input type="hidden" name="credit_email" placeholder="{{ Lang::get('core.email') }}" class="form-control"  value="{{ $row['email'] }}" required autocomplete="off"/>
                                           <i class="icon-envelope form-control-feedback"></i>
                                       </div>
                                   </div>

                                   <div class="form-group" >
                                       <div class="col-md-6">
                                           <button type="submit" class="btn btn-info btn-sm"  > {{ Lang::get('core.restPasswordBySendMail') }} </button>
                                       </div>
                                   </div>


                                   <div class="clr"></div>
                               </form>

                           </div>
                           <div class="col-md-2">

                           </div>
                       </div>
                   </div>
                    -->


                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {

            $("#group_id").jCombo("{{ URL::to('core/users/comboselect?filter=tb_groups:group_id:name') }}", {
                selected_value: '{{ $row['group_id'] }}'
            });

        });

    </script>
@stop

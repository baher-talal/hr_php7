@extends('layouts.app')


@section('content')

<div class="page-content row">
    <!-- Page header -->
    <div class="page-header">
        <div class="page-title">
            <h3> {{ Lang::get('core.configuration_settings') }} <small>{{ Lang::get('core.t_generalsettingsmall') }}</small></h3>
        </div>


        <ul class="breadcrumb">
            <li><a href="{{ URL::to('dashboard') }}">{{ Lang::get('core.home') }}</a></li>
<!--            <li><a href="{{ URL::to('config') }}">{{ Lang::get('core.t_generalsetting') }}</a></li>-->
        </ul>

    </div>
    <div class="page-content-wrapper">
        @if(Session::has('message'))

        {{ Session::get('message') }}

        @endif
        <ul class="parsley-error-list">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        <div class="block-content">
            @include('sximo.config.tab')
            <div class="tab-content m-t">
                <div class="tab-pane active use-padding" id="info">
                    <div class="sbox  ">
                        <div class="sbox-title"></div>
                        <div class="sbox-content">
                            {!! Form::open(array('url'=>'sximo/config/save/', 'class'=>'form-horizontal row', 'files' => true)) !!}
                            <div class="col-sm-6 animated fadeInRight ">
                                <div class="form-group">
                                    <label for="ipt" class=" control-label col-md-4">{{ Lang::get('core.fr_appname') }} </label>
                                    <div class="col-md-8">
                                        <input name="cnf_appname" type="text" id="cnf_appname" class="form-control input-sm" required  value="{{ $tb_config->cnf_appname }}" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="ipt" class=" control-label col-md-4">{{ Lang::get('core.fr_appdesc') }} </label>
                                    <div class="col-md-8">
                                        <input name="cnf_appdesc" type="text" id="cnf_appdesc" class="form-control input-sm" value="{{ $tb_config->cnf_appdesc }}" />
                                    </div>
                                </div>



                                @if(Auth::user()->id  == 1 )
                                 <div class="form-group">
                                    <label for="ipt" class=" control-label col-md-4"> {{ Lang::get('core.cnf_show_builder_tool') }} <br /> <small>  </small> </label>
                                    <div class="col-md-8">
                                        <div class="checkbox">
                                            <input name="cnf_show_builder_tool" type="checkbox"  value="1"
                                                   @if($tb_config->cnf_show_builder_tool ==1) checked @endif
                                                   />
                                        </div>
                                    </div>
                                </div>
                                @endif

                             <div class="form-group">
                                    <label for="ipt" class=" control-label col-md-4">{{ Lang::get('vacations per year') }}  (Days)  </label>
                                    <div class="col-md-8">
                                        <input type="number" min="1"  name="vacations_per_year" type="text" id="cnf_comname" class="form-control input-sm" value="{{ $tb_config->vacations_per_year }}" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="ipt" class=" control-label col-md-4">{{ Lang::get('core.permissions per month') }}  </label>
                                    <div class="col-md-8">
                                        <input type="number" min="1"  name="permissions_per_month" type="text" id="cnf_email" class="form-control input-sm" value="{{ $tb_config->permissions_per_month }}" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="ipt" class=" control-label col-md-4">{{ Lang::get('core.permissions Hours per month') }}  </label>
                                    <div class="col-md-8">
                                        <input type="number" min="1"  name="permissions_hours_per_month" type="text" id="cnf_email" class="form-control input-sm" value="{{ $tb_config->permissions_hours_per_month }}" />
                                    </div>
                                </div>

                                 <div class="form-group">
                                    <label for="ipt" class=" control-label col-md-4">{{ Lang::get('core.delay_notifications_email') }}  </label>
                                    <div class="col-md-8">
                                        <input type="text"  name="delay_notifications_email"  id="delay_notifications_email" class="form-control input-sm" value="{{ $tb_config->delay_notifications_email }}" />
                                    </div>
                                </div>

                                <!--
                                <div class="form-group">
                                    <label for="ipt" class=" control-label col-md-4"> {{ Lang::get('core.multilanguage') }} <br /> <small> Only Layout Interface </small> </label>
                                    <div class="col-md-8">
                                        <div class="checkbox">
                                            <input name="cnf_multilang" type="checkbox" id="cnf_multilang" value="1"
                                                   @if(CNF_MULTILANG ==1) checked @endif
                                                   />  {{ Lang::get('core.fr_enable') }}
                                        </div>
                                    </div>
                                </div>
                                -->

                                <!--
                                <div class="form-group">
                                    <label for="ipt" class=" control-label col-md-4">{{ Lang::get('core.fr_mainlanguage') }} </label>
                                    <div class="col-md-8">

                                        <select class="form-control" name="cnf_lang">

                                            @foreach(SiteHelpers::langOption() as $lang)
                                            <option value="{{  $lang['folder'] }}"
                                                    @if(CNF_LANG ==$lang['folder']) selected @endif
                                                    >{{  $lang['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                -->



                                <div class="form-group">
                                    <label for="ipt" class=" control-label col-md-4"> {{ Lang::get('core.templatefrontend') }} </label>
                                    <div class="col-md-8">

                                        <select class="form-control" name="cnf_theme">
                                            @foreach(SiteHelpers::themeOption() as $t)
                                            <option value="{{  $t['folder'] }}"
                                                    @if($tb_config->cnf_theme ==$t['folder']) selected @endif
                                                    >{{  $t['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="ipt" class=" control-label col-md-4"> Send SMS </label>
                                    <div class="col-md-8">

                                        <select class="form-control" name="sms">
                                            <option value="1"  @if($tb_config->sms ==1) selected @endif>Enable</option>
                                            <option value="0"  @if($tb_config->sms ==0) selected @endif>Disable</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="ipt" class=" control-label col-md-4"> Enable Vacation All Days </label>
                                    <div class="col-md-8">
                                        <select class="form-control" name="enable_vacation_all_days">
                                            <option value="1"  @if($tb_config->enable_vacation_all_days ==1) selected @endif>Enable</option>
                                            <option value="0"  @if($tb_config->enable_vacation_all_days ==0) selected @endif>Disable</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="ipt" class=" control-label col-md-4"> Enable Annual Input </label>
                                    <div class="col-md-8">
                                        <select class="form-control" name="enable_annual_input">
                                            <option value="1"  @if($tb_config->enable_annual_input ==1) selected @endif>Enable</option>
                                            <option value="0"  @if($tb_config->enable_annual_input ==0) selected @endif>Disable</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- <div class="form-group">
                                    <label for="ipt" class=" control-label col-md-4">Delay Time In Hours</label>
                                    <div class="col-md-8">
                                        <input type="number" min="1" step="1" name="delay_time_in_hours" type="text" id="cnf_email" class="form-control input-sm" value="{{ DELAY_TIME_IN_HOURS }}" />
                                    </div>
                                </div> -->

                                <!--
                                <div class="form-group">
                                    <label for="ipt" class=" control-label col-md-4"> {{ Lang::get('core.developmentmode') }}   </label>
                                    <div class="col-md-8">
                                        <div class="checkbox">
                                            <input name="cnf_mode" type="checkbox" id="cnf_mode" value="1"
                                                   @if (defined('CNF_MODE') &&  CNF_MODE =='production') checked @endif
                                                   />  {{ Lang::get('core.developmentproduction') }}
                                        </div>
                                        <small> {{ Lang::get('core.debugcheck') }}  </small>
                                    </div>
                                </div>



                                <div class="form-group">
                                    <label for="ipt" class=" control-label col-md-4">{{ Lang::get('core.vacation_days') }}</label>
                                    <div class="col-md-8">
                                        <input name="cnf_vacation_days" type="number"  min="0" id="cnf_vacation_days" class="form-control input-sm" value="{{ CNF_VACATION }}" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="ipt" class=" control-label col-md-4">{{ Lang::get('core.cnf_tolerance') }}  in minutes</label>
                                    <div class="col-md-8">
                                        <input name="cnf_tolerance" type="number"  min="0" id="cnf_vacation_days" class="form-control input-sm" value="{{ CNF_TOLERANCE }}" />
                                    </div>
                                </div>
                                -->

                            </div>



                            <div class="col-sm-6 animated fadeInRight ">

                                <!--
                                <div class="form-group">
                                    <label for="ipt" class=" control-label col-md-4">{{ Lang::get('core.metakey') }} </label>
                                    <div class="col-md-8">
                                        <textarea class="form-control input-sm" name="cnf_metakey">{{ CNF_METAKEY }}</textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label  class=" control-label col-md-4">{{ Lang::get('core.metadescription') }}</label>
                                    <div class="col-md-8">
                                        <textarea class="form-control input-sm"  name="cnf_metadesc">{{ CNF_METADESC }}</textarea>
                                    </div>
                                </div>
                                -->

                                <div class="form-group">
                                    <label  class=" control-label col-md-4">{{ Lang::get('core.backendlogo') }}</label>
                                    <div class="col-md-8">
                                        <input type="file" name="logo">
                                        <p> <i>{{ Lang::get('core.logo_dimension') }}</i> </p>
                                        <div style="padding:5px; border:solid 1px #ddd; background:#f5f5f5; width:auto;">
                                            @if(file_exists(public_path().'/sximo/images/'.$tb_config->cnf_logo) && $tb_config->cnf_logo !='')
                                            <img src="{{ asset('sximo/images/'.$tb_config->cnf_logo)}}" alt="{{ CNF_APPNAME }}" />
                                            @else
                                            <img src="{{ asset('sximo/images/logo.png')}}" alt="{{ CNF_APPNAME }}" />
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <br>

                                <!--
                                <div class="form-group">
                                    <label for="ipt" class=" control-label col-md-4">{{ Lang::get('core.work_start_hour') }}</label>
                                    <div class="col-md-8">
                                        <input name="cnf_start_hour" type="text"  min="0" id="cnf_vacation_days" class="form-control input-sm  datetimepicker" value="{{ CNF_START_HOUR }}" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="ipt" class=" control-label col-md-4">{{ Lang::get('core.work_end_hour') }}</label>
                                    <div class="col-md-8">
                                        <input name="cnf_end_hour" type="text"  min="0" id="cnf_vacation_days" class="form-control input-sm  datetimepicker" value="{{ CNF_END_HOUR }}" />
                                    </div>
                                </div>

			<div class="form-group">
                            	    <label for="ipt" class=" control-label col-md-4">{{ Lang::get('core.cnf_weekdays') }}</label>
                                    <div class="col-md-8">
									<?php
									$weekdays = explode(',',$cnf_weekdays);
									//	print_r($weekdays);
									$weekdays_opt = array( '0' => 'Sunday' ,  '1' => 'Monday' ,  '2' => 'Tuesday' ,  '3' => 'Wednesday' ,  '4' => 'Thursday' ,  '5' => 'Friday' ,  '6' => 'Saturday'  ); ?>
									<select name='cnf_weekdays[]' rows='5'  multiple class='select2 ' required>
									<?php
									foreach($weekdays_opt as $key=>$val)
									{
										echo "<option  value ='$key' ".( in_array($key,$weekdays) ? " selected='selected' " : '' ).">$val</option>";
									}
									?></select>
								  	</div>
                                </div>
                                -->

                                <div class="form-group">
                                    <label for="ipt" class=" control-label col-md-4">&nbsp;</label>
                                    <div class="col-md-8">
                                        <button class="btn btn-primary" type="submit">{{ Lang::get('core.sb_savechanges') }} </button>
                                    </div>
                                </div>


                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>








    @stop

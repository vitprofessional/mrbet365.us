@extends('otikaAdmin.include')

@section('otikaTitle')
    Dashboard
@endsection

@section('otikaContent')
        <section class="section">
          <div class="section-body">
            <div class="row">
              <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                  <div class="card-header">
                    <h4>Input Text</h4>
                  </div>
                  <div class="card-body">
                    <div class="form-group">
                      <label>Default Input Text</label>
                      <input type="text" class="form-control">
                    </div>
                    <div class="form-group">
                      <label>Phone Number (US Format)</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">
                            <i class="fas fa-phone"></i>
                          </div>
                        </div>
                        <input type="text" class="form-control phone-number">
                      </div>
                    </div>
                    <div class="form-group">
                      <label>Password Strength</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">
                            <i class="fas fa-lock"></i>
                          </div>
                        </div>
                        <input type="password" class="form-control pwstrength" data-indicator="pwindicator">
                      </div>
                      <div id="pwindicator" class="pwindicator">
                        <div class="bar"></div>
                        <div class="label"></div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label>Currency</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">
                            $
                          </div>
                        </div>
                        <input type="text" class="form-control currency">
                      </div>
                    </div>
                    <div class="form-group">
                      <label>Purchase Code</label>
                      <input type="text" class="form-control purchase-code" placeholder="ASDF-GHIJ-KLMN-OPQR">
                    </div>
                    <div class="form-group">
                      <label>Invoice</label>
                      <input type="text" class="form-control invoice-input">
                    </div>
                    <div class="form-group">
                      <label>Date</label>
                      <input type="text" class="form-control datemask" placeholder="YYYY/MM/DD">
                    </div>
                    <div class="form-group">
                      <label>Credit Card</label>
                      <input type="text" class="form-control creditcard">
                    </div>
                    <div class="form-group">
                      <label>Tags</label>
                      <input type="text" class="form-control inputtags">
                    </div>
                  </div>
                </div>
                <div class="card">
                  <div class="card-header">
                    <h4>Image Check</h4>
                  </div>
                  <div class="card-body">
                    <div class="form-group">
                      <label class="form-label">Image Check</label>
                      <div class="row gutters-sm">
                        <div class="col-6 col-sm-4">
                          <label class="imagecheck mb-4">
                            <input name="imagecheck" type="checkbox" value="1" class="imagecheck-input" />
                            <span class="imagecheck-figure">
                              <img src="{{ asset('/') }}otikaAdmin/assets/img/blog/img01.png" alt="}" class="imagecheck-image">
                            </span>
                          </label>
                        </div>
                        <div class="col-6 col-sm-4">
                          <label class="imagecheck mb-4">
                            <input name="imagecheck" type="checkbox" value="2" class="imagecheck-input" checked />
                            <span class="imagecheck-figure">
                              <img src="{{ asset('/') }}otikaAdmin/assets/img/blog/img02.png" alt="}" class="imagecheck-image">
                            </span>
                          </label>
                        </div>
                        <div class="col-6 col-sm-4">
                          <label class="imagecheck mb-4">
                            <input name="imagecheck" type="checkbox" value="3" class="imagecheck-input" />
                            <span class="imagecheck-figure">
                              <img src="{{ asset('/') }}otikaAdmin/assets/img/blog/img03.png" alt="}" class="imagecheck-image">
                            </span>
                          </label>
                        </div>
                        <div class="col-6 col-sm-4">
                          <label class="imagecheck mb-4">
                            <input name="imagecheck" type="checkbox" value="4" class="imagecheck-input" checked />
                            <span class="imagecheck-figure">
                              <img src="{{ asset('/') }}otikaAdmin/assets/img/blog/img04.png" alt="}" class="imagecheck-image">
                            </span>
                          </label>
                        </div>
                        <div class="col-6 col-sm-4">
                          <label class="imagecheck mb-4">
                            <input name="imagecheck" type="checkbox" value="5" class="imagecheck-input" />
                            <span class="imagecheck-figure">
                              <img src="{{ asset('/') }}otikaAdmin/assets/img/blog/img05.png" alt="}" class="imagecheck-image">
                            </span>
                          </label>
                        </div>
                        <div class="col-6 col-sm-4">
                          <label class="imagecheck mb-4">
                            <input name="imagecheck" type="checkbox" value="6" class="imagecheck-input" />
                            <span class="imagecheck-figure">
                              <img src="{{ asset('/') }}otikaAdmin/assets/img/blog/img06.png" alt="}" class="imagecheck-image">
                            </span>
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card">
                  <div class="card-header">
                    <h4>Color</h4>
                  </div>
                  <div class="card-body">
                    <div class="form-group">
                      <label>Simple</label>
                      <input type="text" class="form-control colorpickerinput">
                    </div>
                    <div class="form-group">
                      <label>Pick Your Color</label>
                      <div class="input-group colorpickerinput">
                        <input type="text" class="form-control">
                        <div class="input-group-append">
                          <div class="input-group-text">
                            <i class="fas fa-fill-drip"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="form-label">Color Input</label>
                      <div class="row gutters-xs">
                        <div class="col-auto">
                          <label class="colorinput">
                            <input name="color" type="checkbox" value="primary" class="colorinput-input" />
                            <span class="colorinput-color bg-primary"></span>
                          </label>
                        </div>
                        <div class="col-auto">
                          <label class="colorinput">
                            <input name="color" type="checkbox" value="secondary" class="colorinput-input" />
                            <span class="colorinput-color bg-secondary"></span>
                          </label>
                        </div>
                        <div class="col-auto">
                          <label class="colorinput">
                            <input name="color" type="checkbox" value="danger" class="colorinput-input" />
                            <span class="colorinput-color bg-danger"></span>
                          </label>
                        </div>
                        <div class="col-auto">
                          <label class="colorinput">
                            <input name="color" type="checkbox" value="warning" class="colorinput-input" />
                            <span class="colorinput-color bg-warning"></span>
                          </label>
                        </div>
                        <div class="col-auto">
                          <label class="colorinput">
                            <input name="color" type="checkbox" value="info" class="colorinput-input" />
                            <span class="colorinput-color bg-info"></span>
                          </label>
                        </div>
                        <div class="col-auto">
                          <label class="colorinput">
                            <input name="color" type="checkbox" value="success" class="colorinput-input" />
                            <span class="colorinput-color bg-success"></span>
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                  <div class="card-header">
                    <h4>Select</h4>
                  </div>
                  <div class="card-body">
                    <div class="section-title mt-0">Default</div>
                    <div class="form-group">
                      <label>Default Select</label>
                      <select class="form-control">
                        <option>Option 1</option>
                        <option>Option 2</option>
                        <option>Option 3</option>
                      </select>
                    </div>
                    <div class="section-title">Select 2</div>
                    <div class="form-group">
                      <label>Select2</label>
                      <select class="form-control select2">
                        <option>Option 1</option>
                        <option>Option 2</option>
                        <option>Option 3</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Select2 Multiple</label>
                      <select class="form-control select2" multiple="">
                        <option>Option 1</option>
                        <option>Option 2</option>
                        <option>Option 3</option>
                        <option>Option 4</option>
                        <option>Option 5</option>
                        <option>Option 6</option>
                      </select>
                    </div>
                    <div class="section-title">jQuery Selectric</div>
                    <div class="form-group">
                      <label>jQuery Selectric</label>
                      <select class="form-control selectric">
                        <option>Option 1</option>
                        <option>Option 2</option>
                        <option>Option 3</option>
                        <option>Option 4</option>
                        <option>Option 5</option>
                        <option>Option 6</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>jQuery Selectric Multiple</label>
                      <select class="form-control selectric" multiple="">
                        <option>Option 1</option>
                        <option>Option 2</option>
                        <option>Option 3</option>
                        <option>Option 4</option>
                        <option>Option 5</option>
                        <option>Option 6</option>
                      </select>
                    </div>
                    <div class="section-title">Select Group Button</div>
                    <div class="form-group">
                      <label class="form-label">Button Input</label>
                      <div class="selectgroup w-100">
                        <label class="selectgroup-item">
                          <input type="radio" name="radio1" value="1" class="selectgroup-input-radio" checked>
                          <span class="selectgroup-button">S</span>
                        </label>
                        <label class="selectgroup-item">
                          <input type="radio" name="radio1" value="2" class="selectgroup-input-radio">
                          <span class="selectgroup-button">M</span>
                        </label>
                        <label class="selectgroup-item">
                          <input type="radio" name="radio1" value="3" class="selectgroup-input-radio">
                          <span class="selectgroup-button">L</span>
                        </label>
                        <label class="selectgroup-item">
                          <input type="radio" name="radio1" value="4" class="selectgroup-input-radio">
                          <span class="selectgroup-button">XL</span>
                        </label>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="form-label">Icons input</label>
                      <div class="selectgroup w-100">
                        <label class="selectgroup-item">
                          <input type="radio" name="transportation" value="2" class="selectgroup-input-radio">
                          <span class="selectgroup-button selectgroup-button-icon"><i class="fas fa-mobile"></i></span>
                        </label>
                        <label class="selectgroup-item">
                          <input type="radio" name="transportation" value="1" class="selectgroup-input-radio" checked>
                          <span class="selectgroup-button selectgroup-button-icon"><i class="fas fa-tablet"></i></span>
                        </label>
                        <label class="selectgroup-item">
                          <input type="radio" name="transportation" value="6" class="selectgroup-input-radio">
                          <span class="selectgroup-button selectgroup-button-icon"><i class="fas fa-laptop"></i></span>
                        </label>
                        <label class="selectgroup-item">
                          <input type="radio" name="transportation" value="5" class="selectgroup-input-radio">
                          <span class="selectgroup-button selectgroup-button-icon"><i class="fas fa-times"></i></span>
                        </label>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="form-label">Icon input</label>
                      <div class="selectgroup selectgroup-pills">
                        <label class="selectgroup-item">
                          <input type="radio" name="icon-input" value="1" class="selectgroup-input" checked>
                          <span class="selectgroup-button selectgroup-button-icon"><i class="fas fa-sun"></i></span>
                        </label>
                        <label class="selectgroup-item">
                          <input type="radio" name="icon-input" value="2" class="selectgroup-input">
                          <span class="selectgroup-button selectgroup-button-icon"><i class="fas fa-moon"></i></span>
                        </label>
                        <label class="selectgroup-item">
                          <input type="radio" name="icon-input" value="3" class="selectgroup-input">
                          <span class="selectgroup-button selectgroup-button-icon"><i
                              class="fas fa-cloud-rain"></i></span>
                        </label>
                        <label class="selectgroup-item">
                          <input type="radio" name="icon-input" value="4" class="selectgroup-input">
                          <span class="selectgroup-button selectgroup-button-icon"><i class="fas fa-cloud"></i></span>
                        </label>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="form-label">Your skills</label>
                      <div class="selectgroup selectgroup-pills">
                        <label class="selectgroup-item">
                          <input type="checkbox" name="value" value="HTML" class="selectgroup-input" checked>
                          <span class="selectgroup-button">HTML</span>
                        </label>
                        <label class="selectgroup-item">
                          <input type="checkbox" name="value" value="CSS" class="selectgroup-input">
                          <span class="selectgroup-button">CSS</span>
                        </label>
                        <label class="selectgroup-item">
                          <input type="checkbox" name="value" value="PHP" class="selectgroup-input">
                          <span class="selectgroup-button">PHP</span>
                        </label>
                        <label class="selectgroup-item">
                          <input type="checkbox" name="value" value="JavaScript" class="selectgroup-input">
                          <span class="selectgroup-button">JavaScript</span>
                        </label>
                        <label class="selectgroup-item">
                          <input type="checkbox" name="value" value="Ruby" class="selectgroup-input">
                          <span class="selectgroup-button">Ruby</span>
                        </label>
                        <label class="selectgroup-item">
                          <input type="checkbox" name="value" value="Ruby" class="selectgroup-input">
                          <span class="selectgroup-button">Ruby</span>
                        </label>
                        <label class="selectgroup-item">
                          <input type="checkbox" name="value" value="C++" class="selectgroup-input">
                          <span class="selectgroup-button">C++</span>
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card">
                  <div class="card-header">
                    <h4>Toggle Switches</h4>
                  </div>
                  <div class="card-body">
                    <div class="form-group">
                      <div class="control-label">Toggle switches</div>
                      <div class="custom-switches-stacked mt-2">
                        <label class="custom-switch">
                          <input type="radio" name="option" value="1" class="custom-switch-input" checked>
                          <span class="custom-switch-indicator"></span>
                          <span class="custom-switch-description">Option 1</span>
                        </label>
                        <label class="custom-switch">
                          <input type="radio" name="option" value="2" class="custom-switch-input">
                          <span class="custom-switch-indicator"></span>
                          <span class="custom-switch-description">Option 2</span>
                        </label>
                        <label class="custom-switch">
                          <input type="radio" name="option" value="3" class="custom-switch-input">
                          <span class="custom-switch-indicator"></span>
                          <span class="custom-switch-description">Option 3</span>
                        </label>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="control-label">Toggle switch single</div>
                      <label class="custom-switch mt-2">
                        <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
                        <span class="custom-switch-indicator"></span>
                        <span class="custom-switch-description">I agree with terms and conditions</span>
                      </label>
                    </div>
                  </div>
                </div>
                <div class="card">
                  <div class="card-header">
                    <h4>Date &amp; Time Picker</h4>
                  </div>
                  <div class="card-body">
                    <div class="form-group">
                      <label class="d-block">Date Range Picker With Button</label>
                      <a href="javascript:;" class="btn btn-primary daterange-btn icon-left btn-icon"><i
                          class="fas fa-calendar"></i> Choose Date
                      </a>
                    </div>
                    <div class="form-group">
                      <label>Date Picker</label>
                      <input type="text" class="form-control datepicker">
                    </div>
                    <div class="form-group">
                      <label>Date Time Picker</label>
                      <input type="text" class="form-control datetimepicker">
                    </div>
                    <div class="form-group">
                      <label>Date Range Picker</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">
                            <i class="fas fa-calendar"></i>
                          </div>
                        </div>
                        <input type="text" class="form-control daterange-cus">
                      </div>
                    </div>
                    <div class="form-group">
                      <label>Time Picker</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">
                            <i class="fas fa-clock"></i>
                          </div>
                        </div>
                        <input type="text" class="form-control timepicker">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <div class="settingSidebar">
          <a href="javascript:void(0)" class="settingPanelToggle"> <i class="fa fa-spin fa-cog"></i>
          </a>
          <div class="settingSidebar-body ps-container ps-theme-default">
            <div class=" fade show active">
              <div class="setting-panel-header">Setting Panel
              </div>
              <div class="p-15 border-bottom">
                <h6 class="font-medium m-b-10">Select Layout</h6>
                <div class="selectgroup layout-color w-50">
                  <label class="selectgroup-item">
                    <input type="radio" name="value" value="1" class="selectgroup-input-radio select-layout" checked>
                    <span class="selectgroup-button">Light</span>
                  </label>
                  <label class="selectgroup-item">
                    <input type="radio" name="value" value="2" class="selectgroup-input-radio select-layout">
                    <span class="selectgroup-button">Dark</span>
                  </label>
                </div>
              </div>
              <div class="p-15 border-bottom">
                <h6 class="font-medium m-b-10">Sidebar Color</h6>
                <div class="selectgroup selectgroup-pills sidebar-color">
                  <label class="selectgroup-item">
                    <input type="radio" name="icon-input" value="1" class="selectgroup-input select-sidebar">
                    <span class="selectgroup-button selectgroup-button-icon" data-toggle="tooltip"
                      data-original-title="Light Sidebar"><i class="fas fa-sun"></i></span>
                  </label>
                  <label class="selectgroup-item">
                    <input type="radio" name="icon-input" value="2" class="selectgroup-input select-sidebar" checked>
                    <span class="selectgroup-button selectgroup-button-icon" data-toggle="tooltip"
                      data-original-title="Dark Sidebar"><i class="fas fa-moon"></i></span>
                  </label>
                </div>
              </div>
              <div class="p-15 border-bottom">
                <h6 class="font-medium m-b-10">Color Theme</h6>
                <div class="theme-setting-options">
                  <ul class="choose-theme list-unstyled mb-0">
                    <li title="white" class="active">
                      <div class="white"></div>
                    </li>
                    <li title="cyan">
                      <div class="cyan"></div>
                    </li>
                    <li title="black">
                      <div class="black"></div>
                    </li>
                    <li title="purple">
                      <div class="purple"></div>
                    </li>
                    <li title="orange">
                      <div class="orange"></div>
                    </li>
                    <li title="green">
                      <div class="green"></div>
                    </li>
                    <li title="red">
                      <div class="red"></div>
                    </li>
                  </ul>
                </div>
              </div>
              <div class="p-15 border-bottom">
                <div class="theme-setting-options">
                  <label class="m-b-0">
                    <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input"
                      id="mini_sidebar_setting">
                    <span class="custom-switch-indicator"></span>
                    <span class="control-label p-l-10">Mini Sidebar</span>
                  </label>
                </div>
              </div>
              <div class="p-15 border-bottom">
                <div class="theme-setting-options">
                  <label class="m-b-0">
                    <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input"
                      id="sticky_header_setting">
                    <span class="custom-switch-indicator"></span>
                    <span class="control-label p-l-10">Sticky Header</span>
                  </label>
                </div>
              </div>
              <div class="mt-4 mb-4 p-3 align-center rt-sidebar-last-ele">
                <a href="#" class="btn btn-icon icon-left btn-primary btn-restore-theme">
                  <i class="fas fa-undo"></i> Restore Default
                </a>
              </div>
            </div>
          </div>
        </div>
@endsection
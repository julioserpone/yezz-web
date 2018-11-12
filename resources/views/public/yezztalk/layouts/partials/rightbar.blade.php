  <!-- BEGIN RIGHT SIDEBAR -->            
            <div class="col-md-3 col-sm-3 blog-sidebar">
              <!-- CATEGORIES START -->
              <h2 class="no-top-space">{{ trans('message.categories') }}</h2>
              <ul class="nav sidebar-categories margin-bottom-40">
                @foreach($categories as $cat)
                   <li><a href="/yezztalk/category/{{$cat->ext_id}}">{{ $cat->name }}&nbsp;({{ $cat->themes }})</a></li>    
                @endforeach   
              </ul>
              <!-- CATEGORIES END -->
            
            </div>
            <!-- END RIGHT SIDEBAR -->            
          </div>
        </div>
      </div>
      <!-- END CONTENT -->
    </div>
    <!-- END SIDEBAR & CONTENT -->
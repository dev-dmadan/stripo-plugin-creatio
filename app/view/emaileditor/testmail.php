<?php Defined('BASE_PATH') or die(ACCESS_DENIED); ?>

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Please input your email address testing :</h4>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <input type="email" class="form-control testing-email" id="email" placeholder="input you email..">
            </div>
        </div>
        <div class="modal-footer">
          <button id="send-email" type="button" data-dismiss="modal" class="btn btn-info"> Send </button>
        </div>
      </div>
      
    </div>
  </div>
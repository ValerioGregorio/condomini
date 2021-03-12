<div class="container"  id="container">

        
        
        <div class="col-lg-4 offset-lg-4 col-md-4 offset-md-4 col-sm-12 col-xs-12"  id="wrapper">  

            <h2>Accedi all'area riservata:</h2>

            <form id="form form-login">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="email" class="form-control" id="username" name="username" placeholder="">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    
                    <div class="input-group-append">
                        <input type="password" id="password" name="password" class="form-control" data-toggle="password" placeholder="">
                        <a class="btn btn-default reveal" type="button" onclick="reveal()">
                            <span class="input-group-text">
                                <i class="fa fa-eye"></i>
                            </span>
                        </a>

                    </div>
     
                </div>
                
                
                <input id="subscribe-btn" type="button" class="btn btn-success" onclick="ajaxRequest()" value="LOGIN"/><br>
                <div id="form-message" class="form-message"></div> 
               

            </form>
        </div>
</div>  
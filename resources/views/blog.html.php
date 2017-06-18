<?php $this->extend('base') ?>

<?php $this->start('body') ?>
    <br/>
    <div class="container">
        <!-- Navigation bar -->
        <nav class="navbar navbar-inverse bg-inverse">
            <!--<a class="navbar-brand" href="#">Main</a>-->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="#">Dashboard<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Posts</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Employees</a>
                </li>
            </ul>
            <ul class="navbar-nav navbar-right">
                <li>
                    <button type="button" class="btn btn-default navbar-btn">Sign in</button>
                </li>
            </ul>
        </nav>
        <!-- //Navigation bar -->


        <h1 align="center">MIMF is my framework</h1>
        <br/>
        <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
            data-target="#addPostModal">
            <span class="glyphicon glyphicon-plus"></span> Add post
        </button>
        <br/><br/>
        <div id="postsList"></div>
        <div id="addPostModal" class="modal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="addPostForm">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"
                                aria-hidden="true">&times;</button>
                            <h3 class="modal-title">Add post</h3>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-danger hidden" role="alert" id="submitAnswer">
                                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                <span class="sr-only">Error:</span>
                                <span id='answerText'></span>
                            </div>
                            <div class="form-group">
                              <label for="inputTitle">Title</label>
                              <input type="text" data-noempty class="form-control" id="inputTitle" placeholder="Title" required>
                              <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                              <label for="inputText">Text</label>
                              <textarea data-noempty class="form-control" id="inputText" placeholder="Text" rows="7" required></textarea>
                              <div class="help-block with-errors"></div>
                            </div>                       
                        </div>
                        <div class="modal-footer">
                            <div class="form-group">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
                                <button type="submit" class="btn btn-primary" id="addButton">Add</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>        
        <div id="editPostModal" class="modal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="editPostForm">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"
                                aria-hidden="true">&times;</button>
                            <h3 class="modal-title">Edit post</h3>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-danger hidden" role="alert" id="submitAnswer">
                                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                <span class="sr-only">Error:</span>
                                <span id='answerText'></span>
                            </div>
                            <div class="form-group">
                              <label for="inputTitle">Title</label>
                              <input type="text" data-noempty class="form-control" id="inputTitle" placeholder="Title" required>
                              <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                              <label for="inputText">Text</label>
                              <textarea data-noempty class="form-control" id="inputText" placeholder="Text" rows="7" required></textarea>
                              <div class="help-block with-errors"></div>
                            </div>                       
                        </div>
                        <div class="modal-footer">
                            <div class="form-group">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" id="editButton">Save</button>
                            </div>
                        </div>
                        <input type='hidden' id="inputId" name='id' value=''>
                    </form>
                </div>
            </div>
        </div>                
    </div>
<?php $this->stop('body') ?>

<?php $this->start('script') ?>
    <script>
        
    </script>
<?php $this->stop('script') ?>
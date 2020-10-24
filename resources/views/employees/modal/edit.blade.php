<div class="modal fade edit__employee__data" id="editEmployeeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="employee-modal-title" id="exampleModalLabel"></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="card">
                    <div class="card-body">
                        <form enctype="multipart/form-data" id="editEmployeeForm">
                            @method('PUT')
                            <div class="row">
                            {{-- Avatar --}}
                                <div class="form-group employee__avatar__container row" style="width: 100%">
                                    <div class="col">
                                        <img alt="" class="avatar-preview edit-avatar-preview">                                        
                                    </div>
                                    <div class="col">
                                        <input type="file" name="avatar"  class="form-control avatar edit-avatar-file p-1">
                                    </div>
                                    <div class="invalid-feedback avatar-error"></div>
                                </div>
                                <div class="col">
                                {{-- Firstname --}}
                                    <div class="form-group">
                                        <label for="employee-first_name" class="col-form-label">Firstname:</label>
                                        <input type="text" name="first_name"  class="form-control first_name" required autocomplete>
                                        <div class="invalid-feedback first_name-error"></div>
                                    </div>
                                </div>
                                <div class="col">
                                {{-- Lastname --}}
                                    <div class="form-group">
                                        <label for="employee-last_name" class="col-form-label">Lastname:</label>
                                        <input type="text" name="last_name"  class="form-control last_name" required autocomplete>
                                        <div class="invalid-feedback last_name-error"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="employee-email" class="col-form-label">Email:</label>
                                <input type="email" name="email"  class="form-control email" required autocomplete>
                                <div class="invalid-feedback email-error"></div>
                            </div>
                            <div class="form-group">
                                <label for="employee-phone" class="col-form-label">Phone:</label>
                                <input type="tel" 
                                    name="phone"  
                                    class="form-control phone" 
                                    placeholder="123-12-123"
                                    pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" required autocomplete>
                                    <div class="invalid-feedback phone-error"></div>
                            </div>
                            <div class="form-group">
                                <label for="employee-salary" class="col-form-label">Salary:</label>
                                <input type="text" name="salary"  class="form-control salary" required autocomplete>
                                <div class="invalid-feedback salary-error"></div>
                            </div>
                            <div class="form-group">
                                <label for="employee-commission" class="col-form-label">Commission:</label>
                                <input type="text" name="commission"  class="form-control commission" required autocomplete>
                                <div class="invalid-feedback commission-error"></div>
                            </div>  

                            <input type="hidden" name="employee_id"  class="employee_id">
                            
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-warning update-employee">Update</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Cancel</button>
                            </div>
                
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
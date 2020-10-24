<div class="modal fade create__employee__data" id="createEmployeeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <form enctype="multipart/form-data" id="createEmployeeForm">
                            <div class="row">
                            {{-- Avatar --}}
                                <div class="form-group employee__avatar__container row" style="width: 100%">
                                    <div class="col">
                                        <img src="{{ asset('storage/employees/avatars/no_image.png') }}" class="create-avatar-preview">                                        
                                    </div>
                                    <div class="col">
                                        <input type="file" name="avatar"  class="form-control avatar create-avatar-file p-1">
                                    </div>
                                    <div class="invalid-feedback avatar-error"></div>
                                </div>
                                <div class="col">
                                {{-- Firstname --}}
                                    <div class="form-group">
                                        <label for="employee-first_name" class="col-form-label">Firstname:</label>
                                        <input type="text" name="first_name"  class="form-control first_name" required>
                                        <div class="invalid-feedback first_name-error"></div>
                                    </div>
                                </div>
                                <div class="col">
                                {{-- Lastname --}}
                                    <div class="form-group">
                                        <label for="employee-last_name" class="col-form-label">Lastname:</label>
                                        <input type="text" name="last_name"  class="form-control last_name" required>
                                        <div class="invalid-feedback last_name-error"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="employee-email" class="col-form-label">Email:</label>
                                <input type="email" name="email"  class="form-control email" required>
                                <div class="invalid-feedback email-error"></div>
                            </div>
                            <div class="form-group">
                                <label for="employee-phone" class="col-form-label">Phone:</label>
                                <input type="tel" 
                                    name="phone"  
                                    class="form-control phone" 
                                    placeholder="123-12-123"
                                    pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" required>
                                    <div class="invalid-feedback phone-error"></div>
                            </div>
                            <div class="form-group">
                                <label for="employee-salary" class="col-form-label">Salary:</label>
                                <input type="text" name="salary"  class="form-control salary" required>
                                <div class="invalid-feedback salary-error"></div>
                            </div>
                            <div class="form-group">
                                <label for="employee-commission" class="col-form-label">Commission:</label>
                                <input type="text" name="commission"  class="form-control commission" required>
                                <div class="invalid-feedback commission-error"></div>
                            </div>  
                            
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success store-employee">Create Employee</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Cancel</button>
                            </div>
                
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
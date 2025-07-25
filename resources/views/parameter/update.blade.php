<div class="modal fade text-left" id="updateModal" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
         role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Edit Data</h4>
                <button type="button" class="close" data-bs-dismiss="modal"
                        aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <form action="javascript:void(0)" id="formUpdate">
                <div class="modal-body">
                    <label for="total">Nilai</label>
                    <input id="idParameter" name="idParameter" type="hidden">
                    <div class="form-group">
                        <input id="alphaEdit" name="alphaEdit" type="number" step="any" placeholder="Total" min="0"
                               class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary ms-1"
                    >
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Update</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

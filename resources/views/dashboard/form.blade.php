<!-- Modal -->
<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
            </div>
            <div class="modal-body">
                <ul id="error_list">

                </ul>
                <form action="" method="post">
                    @csrf
                    @method('post')
                    <input type="hidden" name="_method" value="PUT">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ old('name') }}">
                    </div>
                    <div class="form-group mt-2">
                        <label for="phone_number">Phone Number</label>
                        <input type="text" class="form-control" id="phone_number" name="phone_number"
                            value="{{ old('phone_number') }}">
                    </div>
                    <div class="form-group mt-2">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address"
                            value="{{ old('address') }}">
                    </div>
                    <div class="form-group mt-2">
                        <label for="date_of_birth">Date Of Birth</label>
                        <input type="date" class="form-control" id="date_of_birth" name="date_of_birth"
                            value="{{ old('date_of_birth') }}">
                    </div>
                    <div class="form-group mt-2">
                        <label for="date_of_joining">Date Of Joining</label>
                        <input type="date" class="form-control" id="date_of_joining" name="date_of_joining"
                            value="{{ old('date_of_joining') }}">
                    </div>
                    <div class="form-group mt-2">
                        <label for="gender">Gender</label>
                        <select class="form-control" name="gender" id="gender">
                            <option value="MAN">MAN</option>
                            <option value="WOMAN">WOMAN</option>
                        </select>
                    </div>
                    <div class="form-group mt-2">
                        <label for="department">Department</label>
                        <select class="form-control" name="department" id="department">
                            @foreach ($departments as $item)
                                <option value="{{ $item->department_id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

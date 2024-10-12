<div class="modal fade" id="createVideoModal" tabindex="-1" aria-labelledby="createVideoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form id="uploadVideoForm" action="{{ route('admin.videos.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title">Upload New Video</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <div class="mb-3">
                      <label for="title" class="form-label">Video Title</label>
                      <input type="text" class="form-control" id="title" name="title" required>
                  </div>
                  <div class="mb-3">
                      <label for="thumbnail" class="form-label">Thumbnail</label>
                      <input type="file" class="form-control" id="thumbnail" name="thumbnail" accept="image/*" required>
                  </div>
                  <div class="mb-3">
                      <label for="video" class="form-label">Video File</label>
                      <input type="file" class="form-control" id="video" name="video" accept="video/*" required>
                  </div>
                  <div class="mb-3">
                      <label for="price" class="form-label">Price (IDR)</label>
                      <input type="number" class="form-control" id="price" name="price" min="0" step="0.01" required>
                  </div>
                  <!-- Loading indicator -->
    <div id="loadingIndicator" class="d-none text-center">
        <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <p>Uploading...</p>
    </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Upload Video</button>
              </div>
          </div>
      </form>
    </div>
  </div>
  <!-- Include AJAX script here -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function () {
        $('#uploadVideoForm').on('submit', function (e) {
            e.preventDefault(); // Prevent form from submitting the traditional way
            
            var formData = new FormData(this);
            var loadingIndicator = $('#loadingIndicator');
            
            // Show loading indicator
            loadingIndicator.removeClass('d-none');
    
            $.ajax({
                url: "{{ route('admin.videos.store') }}", // Replace with your video store route
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    // Hide loading indicator
                    loadingIndicator.addClass('d-none');
                    console.log('Upload Success:', response); // Log response
                    window.location.reload(); // Reload page after upload
                },
                error: function (xhr) {
                    // Hide loading indicator
                    loadingIndicator.addClass('d-none');
                    console.log('Upload Error:', xhr.responseText); // Log error
                    alert('Upload failed: ' + xhr.responseText);
                }
            });
        });
    });
    </script>
    
    
  
<div class="modal fade" id="createVideoModal" tabindex="-1" aria-labelledby="createVideoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form action="{{ route('admin.videos.store') }}" method="POST" enctype="multipart/form-data">
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
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Upload Video</button>
              </div>
          </div>
      </form>
    </div>
  </div>
  
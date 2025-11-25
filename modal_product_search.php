<div class="modal fade" id="productSearchModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Search Products</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        <!-- Search Bar -->
        <div class="input-group mb-3">
          <input 
            type="text" 
            id="productSearchInput"
            class="form-control" 
            placeholder="Search product name..."
          >
          <button class="btn btn-primary" id="searchBtn">
            <i class="fa-solid fa-magnifying-glass"></i>
          </button>
        </div>

        <!-- Results dere -->
        <div id="searchResults"></div>

      </div>

    </div>
  </div>
</div>

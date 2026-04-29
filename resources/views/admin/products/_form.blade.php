<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Name</label>
        <input name="name" value="{{ old('name', $product->name ?? '') }}" required
               class="w-full rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
        @error('name') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Category</label>
        <select name="category_id" required
                class="w-full rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
            <option value="">Select a category</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id ?? '') == $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>
        @error('category_id') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
         <label class="block text-sm font-medium text-slate-700 mb-1">Old Price</label>
        <input name="price" type="number" step="0.01" min="0" value="{{ old('price', $product->price ?? '') }}" required
               class="w-full rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
         <p class="mt-1 text-xs text-slate-500">This will be shown as the crossed-out old price when a current price is set.</p>
        @error('price') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
         <label class="block text-sm font-medium text-slate-700 mb-1">Current Price</label>
        <input name="discount_price" type="number" step="0.01" min="0" value="{{ old('discount_price', $product->discount_price ?? '') }}"
             placeholder="Leave empty to use the old price as current price"
               class="w-full rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
         <p class="mt-1 text-xs text-slate-500">If you enter a lower current price, the old price will appear inside a del tag on the storefront.</p>
        @error('discount_price') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Promo Label</label>
        <input name="promo_label" value="{{ old('promo_label', $product->promo_label ?? '') }}"
               placeholder="Example: EID DEAL, FLASH SALE"
               class="w-full rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
        @error('promo_label') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Stock</label>
        <input name="stock" type="number" min="0" value="{{ old('stock', $product->stock ?? 0) }}" required
               class="w-full rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
        @error('stock') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
    </div>
</div>
<div>
    <label class="block text-sm font-medium text-slate-700 mb-1">Description</label>
    <textarea name="description" rows="5"
              class="w-full rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm">{{ old('description', $product->description ?? '') }}</textarea>
</div>
<div>
    <label class="block text-sm font-medium text-slate-700 mb-1">Image</label>
    @if (!empty($product?->image))
        <img src="{{ $product->image_url }}" class="h-24 rounded-lg mb-2">
    @endif
    <input type="file" name="image" class="text-sm">
    @error('image') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
</div>

@if ($product && $product->exists)
<div x-data="multiImageUpload()" @upload-error.window="showError($event.detail)" @upload-success.window="refreshImages($event.detail)">
    <div class="border-t border-slate-200 my-6 pt-6">
        <h3 class="text-sm font-semibold text-slate-900 mb-4">Additional Product Images</h3>

        <!-- Upload Zone -->
        <div class="relative border-2 border-dashed border-slate-300 rounded-lg p-6 text-center hover:border-indigo-400 transition cursor-pointer"
             @click="$refs.fileInput.click()"
             @dragover="isDragging = true"
             @dragleave="isDragging = false"
             @drop.prevent="handleDrop($event)"
             :class="isDragging ? 'bg-indigo-50 border-indigo-400' : ''">
            <input type="file" x-ref="fileInput" multiple accept="image/*" @change="handleFiles($event)" class="hidden">
            <svg class="mx-auto h-12 w-12 text-slate-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-8l-3.172-3.172a4 4 0 00-5.656 0L28 12m0 0L16.828 0.828a4 4 0 00-5.656 0L8 4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <p class="mt-2 text-sm text-slate-600">Drag and drop images here, or click to select files</p>
            <p class="text-xs text-slate-500 mt-1">PNG, JPG, GIF or WEBP (max 5MB each)</p>
        </div>

        <!-- Upload Progress -->
        <template x-if="isUploading">
            <div class="mt-4 space-y-2">
                <template x-for="(file, index) in uploadingFiles" :key="index">
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-slate-600" x-text="file.name"></span>
                        <div class="flex-1 bg-slate-200 rounded-full h-2">
                            <div class="bg-indigo-600 h-2 rounded-full transition-all" :style="`width: ${file.progress}%`"></div>
                        </div>
                    </div>
                </template>
            </div>
        </template>

        <!-- Error Message -->
        <template x-if="error">
            <div class="mt-4 p-3 bg-rose-50 border border-rose-200 rounded-lg text-sm text-rose-700">
                <p x-text="error"></p>
            </div>
        </template>

        <!-- Images Gallery -->
        <template x-if="images.length > 0">
            <div class="mt-6">
                <h4 class="text-sm font-medium text-slate-700 mb-3">Product Images</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" x-ref="imagesGallery">
                    <template x-for="(image, index) in images" :key="image.id">
                        <div class="relative group bg-slate-50 rounded-lg overflow-hidden border border-slate-200">
                            <img :src="image.image_url" :alt="image.alt_text" class="h-32 w-full object-cover">
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100">
                                <button type="button" @click="deleteImage(image.id)" class="bg-rose-600 text-white p-2 rounded-full hover:bg-rose-700" title="Delete">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                                <button type="button" @click="setAsPrimary(image.id)" :class="image.is_primary ? 'bg-indigo-600' : 'bg-slate-600'" class="text-white p-2 rounded-full hover:bg-indigo-700" title="Set as primary">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </button>
                            </div>
                            <template x-if="image.is_primary">
                                <div class="absolute top-2 right-2 bg-indigo-600 text-white text-xs px-2 py-1 rounded">Primary</div>
                            </template>
                        </div>
                    </template>
                </div>
            </div>
        </template>
    </div>
</div>

<script>
    function multiImageUpload() {
        return {
            images: [],
            isUploading: false,
            isDragging: false,
            uploadingFiles: [],
            error: null,
            productId: {{ $product->id }},

            async init() {
                await this.refreshImages();
            },

            async refreshImages(data = null) {
                try {
                    const response = await fetch(`/api/products/${this.productId}/images`, {
                        headers: {
                            'Accept': 'application/json',
                            'Authorization': `Bearer ${document.querySelector('meta[name="api-token"]')?.content || ''}`
                        }
                    });

                    if (response.ok) {
                        const result = await response.json();
                        this.images = result.images;
                    }
                } catch (err) {
                    console.error('Failed to load images:', err);
                }
            },

            async handleFiles(event) {
                const files = Array.from(event.target.files);
                await this.uploadFiles(files);
                event.target.value = '';
            },

            handleDrop(event) {
                this.isDragging = false;
                const files = Array.from(event.dataTransfer.files).filter(f => f.type.startsWith('image/'));
                this.uploadFiles(files);
            },

            async uploadFiles(files) {
                if (files.length === 0) return;

                this.isUploading = true;
                this.error = null;
                this.uploadingFiles = files.map((f, i) => ({ name: f.name, progress: 0 }));

                const formData = new FormData();
                files.forEach(file => formData.append('images[]', file));

                try {
                    const xhr = new XMLHttpRequest();

                    xhr.upload.addEventListener('progress', (e) => {
                        if (e.lengthComputable) {
                            const percentComplete = (e.loaded / e.total) * 100;
                            this.uploadingFiles.forEach(f => f.progress = percentComplete);
                        }
                    });

                    xhr.addEventListener('load', () => {
                        if (xhr.status === 201) {
                            const result = JSON.parse(xhr.responseText);
                            this.images.push(...result.images);
                            this.isUploading = false;
                            this.uploadingFiles = [];
                        } else {
                            const error = JSON.parse(xhr.responseText);
                            this.error = error.message || 'Upload failed';
                            this.isUploading = false;
                        }
                    });

                    xhr.addEventListener('error', () => {
                        this.error = 'Upload failed';
                        this.isUploading = false;
                    });

                    const token = document.querySelector('meta[name="csrf-token"]').content;
                    xhr.open('POST', `/api/products/${this.productId}/images/upload`);
                    xhr.setRequestHeader('X-CSRF-TOKEN', token);
                    xhr.send(formData);
                } catch (err) {
                    this.error = err.message;
                    this.isUploading = false;
                }
            },

            async deleteImage(imageId) {
                if (!confirm('Are you sure you want to delete this image?')) return;

                try {
                    const response = await fetch(`/api/product-images/${imageId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                            'Authorization': `Bearer ${document.querySelector('meta[name="api-token"]')?.content || ''}`
                        }
                    });

                    if (response.ok) {
                        this.images = this.images.filter(img => img.id !== imageId);
                    } else {
                        const error = await response.json();
                        this.error = error.message || 'Failed to delete image';
                    }
                } catch (err) {
                    this.error = err.message;
                }
            },

            async setAsPrimary(imageId) {
                try {
                    const response = await fetch(`/api/product-images/${imageId}`, {
                        method: 'PATCH',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            'Authorization': `Bearer ${document.querySelector('meta[name="api-token"]')?.content || ''}`
                        },
                        body: JSON.stringify({ is_primary: true })
                    });

                    if (response.ok) {
                        const result = await response.json();
                        this.images = this.images.map(img => ({
                            ...img,
                            is_primary: img.id === imageId
                        }));
                    } else {
                        const error = await response.json();
                        this.error = error.message || 'Failed to update image';
                    }
                } catch (err) {
                    this.error = err.message;
                }
            },

            showError(detail) {
                this.error = detail.message;
            }
        }
    }
</script>
@endif

<div class="flex flex-wrap gap-6 pt-2">
    <label class="inline-flex items-center gap-2 text-sm text-slate-700">
        <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $product?->is_featured ?? false)) class="rounded text-indigo-600 focus:ring-indigo-500">
        Featured
    </label>
    <label class="inline-flex items-center gap-2 text-sm text-slate-700">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $product?->is_active ?? true)) class="rounded text-indigo-600 focus:ring-indigo-500">
        Active
    </label>
</div>

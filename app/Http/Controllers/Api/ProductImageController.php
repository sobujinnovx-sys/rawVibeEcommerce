<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use App\Services\ImageUploadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ProductImageController extends Controller
{
    /**
     * Upload multiple images for a product.
     */
    public function upload(Request $request, Product $product): JsonResponse
    {
        $this->authorize('update', $product);

        try {
            $validated = $request->validate([
                'images' => 'required|array',
                'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            ]);

            $uploadedImages = [];

            foreach ($validated['images'] as $image) {
                $imagePath = ImageUploadService::upload($image, 'products');

                $productImage = ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $imagePath,
                    'sort_order' => $product->images()->max('sort_order') + 1 ?? 0,
                ]);

                $uploadedImages[] = [
                    'id' => $productImage->id,
                    'image_url' => $productImage->image_url,
                    'sort_order' => $productImage->sort_order,
                    'is_primary' => $productImage->is_primary,
                ];
            }

            return response()->json([
                'message' => 'Images uploaded successfully',
                'images' => $uploadedImages,
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to upload images',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get all images for a product.
     */
    public function index(Product $product): JsonResponse
    {
        $images = $product->images()
            ->select(['id', 'product_id', 'image_path', 'alt_text', 'is_primary', 'sort_order'])
            ->get()
            ->map(fn ($image) => [
                'id' => $image->id,
                'image_url' => $image->image_url,
                'alt_text' => $image->alt_text,
                'is_primary' => $image->is_primary,
                'sort_order' => $image->sort_order,
            ]);

        return response()->json([
            'images' => $images,
        ]);
    }

    /**
     * Delete an image.
     */
    public function destroy(ProductImage $productImage): JsonResponse
    {
        $this->authorize('update', $productImage->product);

        try {
            ImageUploadService::delete($productImage->image_path);
            $productImage->delete();

            return response()->json([
                'message' => 'Image deleted successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete image',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update image details.
     */
    public function update(Request $request, ProductImage $productImage): JsonResponse
    {
        $this->authorize('update', $productImage->product);

        try {
            $validated = $request->validate([
                'alt_text' => 'sometimes|string|max:255',
                'is_primary' => 'sometimes|boolean',
                'sort_order' => 'sometimes|integer|min:0',
            ]);

            if (isset($validated['is_primary']) && $validated['is_primary']) {
                // Remove primary flag from other images
                $productImage->product->images()
                    ->where('id', '!=', $productImage->id)
                    ->update(['is_primary' => false]);
            }

            $productImage->update($validated);

            return response()->json([
                'message' => 'Image updated successfully',
                'image' => [
                    'id' => $productImage->id,
                    'image_url' => $productImage->image_url,
                    'alt_text' => $productImage->alt_text,
                    'is_primary' => $productImage->is_primary,
                    'sort_order' => $productImage->sort_order,
                ],
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update image',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Reorder images.
     */
    public function reorder(Request $request, Product $product): JsonResponse
    {
        $this->authorize('update', $product);

        try {
            $validated = $request->validate([
                'images' => 'required|array',
                'images.*.id' => 'required|integer|exists:product_images,id',
                'images.*.sort_order' => 'required|integer|min:0',
            ]);

            foreach ($validated['images'] as $imageData) {
                ProductImage::where('id', $imageData['id'])
                    ->where('product_id', $product->id)
                    ->update(['sort_order' => $imageData['sort_order']]);
            }

            return response()->json([
                'message' => 'Images reordered successfully',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to reorder images',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}

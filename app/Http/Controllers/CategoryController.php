<?php

namespace App\Http\Controllers;

use App\DTO\CategoryDTO;
use App\Http\Requests\Categories\DeleteCategoryRequest;
use App\Http\Requests\Categories\StoreCategoryRequest;
use App\Http\Requests\Categories\UpdateCategoryRequest;
use App\Services\Category\CategoryService;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    public function __construct(
        public CategoryService $categoryService
    )
    {}

    public function store(StoreCategoryRequest $request): JsonResponse
    {
        try {
            $userId = $request->user()->id;
            $categoryDTO = CategoryDTO::from([
                ...$request->all(),
                'user_id' => $userId,
            ]);

            $categoryResponse = $this->categoryService->save($categoryDTO);

            return response()->json([
                'success' => true,
                'message' => 'Category added to list.',
                'data' => $categoryResponse,
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ], 400);
        }
    }

    public function update(UpdateCategoryRequest $request): JsonResponse
    {
        try {
            $categoryDTO = CategoryDTO::from($request->all());

            $categoryResponse = $this->categoryService->update($categoryDTO);

            return response()->json([
                'success' => true,
                'message' => 'Category added to list.',
                'data' => $categoryResponse,
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ], 400);
        }
    }

    public function delete(DeleteCategoryRequest $request): JsonResponse
    {
        try {
            $this->categoryService->delete($request->get('id'));

            return response()->json([
                'success' => true,
                'message' => 'Category deleted.',
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ], 400);
        }
    }
}

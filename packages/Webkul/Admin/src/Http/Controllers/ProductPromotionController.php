<?php

namespace Webkul\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Webkul\Product\Models\Product;
use Webkul\ProductPromotion\Repositories\ProductPromotionRepository;

class ProductPromotionController extends Controller
{
    protected $productPromotionRepository;

    public function __construct(ProductPromotionRepository $productPromotionRepository)
    {
        $this->productPromotionRepository = $productPromotionRepository;
    }

    public function index()
    {
        $promotions = $this->productPromotionRepository->all();
        return view('admin::promotions\index', compact('promotions'));
    }

    public function create()
    {
        $products = Product::all();
        return view('admin::promotions\create', ['products' => $products]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'nullable|string',
            'banner' => 'nullable|string',
            'starts_from' => 'nullable|date',
            'ends_till' => 'nullable|date',
            'status' => 'boolean',
            'products' => 'required|array',
            'products.*.product_id' => 'required|integer',
            'products.*.discount_amount' => 'required|numeric',
            'products.*.discount_type' => 'required|in:flat,percentage',
        ]);

        $this->productPromotionRepository->create($data);

        return redirect()->route('admin.promotions.index')->with('success', 'Promotion created successfully.');
    }

    public function edit($id)
    {
        $promotion = $this->productPromotionRepository->find($id);
        return view('admin::promotions\edit', compact('promotion'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title' => 'nullable|string',
            'banner' => 'nullable|string',
            'starts_from' => 'nullable|date',
            'ends_till' => 'nullable|date',
            'status' => 'boolean',
            'products' => 'required|array',
            'products.*.product_id' => 'required|integer',
            'products.*.discount_amount' => 'required|numeric',
            'products.*.discount_type' => 'required|in:flat,percentage',
        ]);

        $this->productPromotionRepository->update($data, $id);

        return redirect()->route('admin.promotions.index')->with('success', 'Promotion updated successfully.');
    }

    public function destroy($id)
    {
        $this->productPromotionRepository->delete($id);
        return redirect()->route('admin.promotions.index')->with('success', 'Promotion deleted successfully.');
    }
}

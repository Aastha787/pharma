<div>
                <div class="row">
                    @forelse ($products as $productItem)
                    <div class=" col-md-6">
                        <div class="product-card">
                            <div class="product-card-img">
                                @if($productItem->quantity>0)
                                <label class="stock bg-success">In Stock</label>
                                @else
                                    <label class="stock bg-danger">out of Stock</label>
                                @endif
                                @if($productItem->productImages->count() > 0)
                                    @endif
                                    <a href="{{url('/collections/'.$productItem->category->slug.'/'.$productItem->slug)}}">
                                    <img src="{{asset($productItem->productImages[0]->image)}}"  width="5px" height="250px" alt="">
                                    </a>
                            </div>


                            <div class="product-card-body">
                                <h5 class="product-name">
                                    <a href="{{url('/collections/'.$productItem->category->slug.'/'.$productItem->slug)}}">
                                        {{$productItem->name}}
                                    </a>
                                </h5>
                                <div>
                                    <span class="selling-price">Rs{{$productItem->selling_price}}</span>
                                    <span class="original-price">Rs{{$productItem->original_price}}</span>
                                </div>

                                <div class="mt-2">
                                    <div class="mt-2">
                                        <span class="btn btn-danger" wire:click="decrementQuantity"><i class="fa fa-minus"></i></span>
                                        <input type="text" wire:model="quantityCount" value="{{$this->quantityCount}}" readonly class="input-quantity"/>
                                        <span class="btn btn-success" wire:click="incrementQuantity"><i class="fa fa-plus"></i></span>
                                    </div>
                                </div>

                                <div class="mt-2">
                                    <button type="button" wire:click="addToCart({{$productItem->id}})" class="btn btn1">
                                        <i class="fa fa-shopping-cart"></i>Add To Cart
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                        @empty
                            <div class="col-md-12">
                                <div class="p-2">
                                    <h4>No products available for{{$category->name}}</h4>
                                </div>
                            </div>
                            @endforelse

</div>
</div>

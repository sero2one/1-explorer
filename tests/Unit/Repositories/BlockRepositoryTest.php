<?php

declare(strict_types=1);

use App\Models\Block;
use App\Repositories\BlockRepository;

beforeEach(fn () => $this->subject = new BlockRepository());

it('should find a block by its height', function () {
    $block = Block::factory()->create();

    expect($this->subject->findByHeight($block->height->toNumber()))->toBeInstanceOf(Block::class);
});
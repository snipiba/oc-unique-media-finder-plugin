<?php

use PHPUnit\Framework\TestCase;

use SNiPI\UniqueMediaFinder\Classes\UniqueMediaFinder;
use SNiPI\UniqueMediaFinder\UnsplashFinder;
use SNiPI\UniqueMediaFinder\PexelsFinder;
use SNiPI\UniqueMediaFinder\PixabayFinder;

class SearchProvidersTest extends TestCase {

	protected $providers;
	
	public function testInitialization() {
		$providers = [];
        $providers['unsplash'] = new UnsplashFinder;
        $providers['pexels'] = new PexelsFinder;
        $providers['pixabay'] = new PixabayFinder;
        $this->providers = $providers;
        $this->assertTrue(is_array($providers));
	}	

	public function testUnsplashProvider() {
		$this->assertTrue(array_key_exists('unsplash', $this->providers));
	}

	public function testPixabayProvider() {
		$this->assertTrue(array_key_exists('pixabay', $this->providers));
	}

	public function testPexelsProvider() {
		$this->assertTrue(array_key_exists('pexels', $this->providers));
	}
}
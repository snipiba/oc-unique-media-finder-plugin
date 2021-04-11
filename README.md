![cover](https://www.snipi.sk/storage/app/media/projekty/pluginy/cover.jpg)

Are u sick from searching images, downloading and reuploading? Here is a light solution for creating all from one place.

## Developer
If you want know more, you can read [article about this plugin on my blog](https://www.snipi.sk/clanky/octobercms/rozsirenie-medii-o-moznost-vyhadavania-v-databazach)

## Search for stock photos in Unsplash or Pexels
For current most popular stock databases is used Unsplash and Pexels integration. Then you are able to obtain api keys for both and use both APIs for searching and downloading pictures.

## Feature
This is currently quick extension, but i will provide more features for this, like informations, loading collections from current author, searching by multiple parameters like photo ortientation etc.

### Bug reporting
Please, if you find some issues or have any ideas, please, provide feedback at snipi[at]snipi[dot]sk

## Installation
For install this plugin you can use Plugin installation tool in octobercms backend, where type SNiPI.UniqueMediaFinder

## First steps
To allow search you need to create an applications in unsplash.com or pexels.com, where you can obtain api keys. This api keys is provided in plugin settings.

## Searching
To search, navigate to Media Library and look for icon with magnify glass. Click on icon opens modal window with input for search keyword. After hit "Search now" you get list of results. Each implementation has separated "tab" for results.

## Dowloading
On search results are square previews. Move your cursor over, to show buttons. One (with eye) provide funcionality to show larger preview. One (with download icon) allows you to download current picture to your library.

# Documentation
## Installation
For install this plugin you can use Plugin installation tool in octobercms backend, where type 
```
SNiPI.UniqueMediaFinder
```

## First steps
To allow search you need to create an applications in unsplash.com or pexels.com, where you can obtain api keys. This api keys is provided in plugin settings.

## Searching
To search, navigate to Media Library and look for icon with magnify glass. Click on icon opens modal window with input for search keyword. After hit "Search now" you get list of results. Each implementation has separated "tab" for results.

## Dowloading
On search results are square previews. Move your cursor over, to show buttons. One (with eye) provide funcionality to show larger preview. One (with download icon) allows you to download current picture to your library.

## Known limitations
Many of limitations is based on specific provider. Please, see table bellow.

Provider | Limit per hour | Limit per month
------------|--------------------|--------------
Unsplash | 50 (demo) 5000 (verified) | -
Pexels | 200 | 20000 
Pixabay | 5000 | -

### Unsplash verification
When u will get 5000 request per hour limit, you need to send your application for verification with screenshots, etc. Here i will probably talk more with unsplash api team, to get specific allowance for this plugin.

### Pexels
You are able to send mail to api@pexels.com to get more rate limit.

### Pixabay
Here is probably good way to get many photos, but, here is other limitation - maximum quality of image. In basic api requests you can get pictures with maximum 1280 px large size. For full HD images you need to send apply for full api access.


[![Buymeacoffee.com](https://www.snipi.sk/storage/app/media/bmc-full-logo-no-background.png)](https://www.buymeacoffee.com/snipiba)
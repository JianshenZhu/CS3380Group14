"""""""""""""""""""""""""""""""""""""
" Author:
"   Jason Weinzierl
"
" Version:
"   2017-01-31
"
" Sections:
"   -> General
"   -> VIM UI
"   -> Colors and Fonts
"   -> Text, tab, and indent related
"   -> Mappings
"""""""""""""""""""""""""""""""""""""

"""""""""""""""""""""""""""""""""""""
" => General
"""""""""""""""""""""""""""""""""""""
" set to auto read when a file is changed from the outside
set autoread

" no compatibility with vi
set nocompatible

" ask to confirm instead of failing
set confirm

"""""""""""""""""""""""""""""""""""""
" => VIM UI
"""""""""""""""""""""""""""""""""""""
" keep lines above/below and right/left of the cursor
set scrolloff=7
set sidescrolloff=7

" a buffer becomes hidden when it is abandoned
set hidden

" turn on the WiLd menu
set wildmenu
set wildmode=list:longest,full

" ignore compiled files
set wildignore=*.o,*~,*.pyc

" shows what you are typing as a command
set showcmd

" highlight search results
set hlsearch

" search cases better
set ignorecase
set smartcase

" move cursor to matched string
set incsearch

" don't redraw when executing macros
set lazyredraw

" always show current position
set ruler

" height of command bar
set cmdheight=2

" show line numbers
set number

" show matching brackets
set showmatch

" how many 1/10 s to blink matching brackets
set matchtime=2

" use mouse in all modes
set mouse=a

" RegEx
set magic

" no alarm bells
set noerrorbells
set novisualbell
set t_vb=

" time before mapped key sequence times out
set timeoutlen=500

" backspace behave like other applications
set backspace=indent,eol,start

"""""""""""""""""""""""""""""""""""""
" => Colors and Fonts
"""""""""""""""""""""""""""""""""""""
" enable syntax highlighting
syntax on

" dark or light theme
set background=dark

" desert scheme easy on the eyes
colorscheme desert

" set extra options in GUI mode
if has("gui_running")
    set guioptions-=T
    set guioptions+=e
    set t_Co=256
    set guitablabel=%M\ %t
endif

" set UTF-8 as standard
set encoding=utf-8
set fileencoding=utf-8
set termencoding=utf-8

" use Unix as the standard file type
set ffs=unix,dos,mac

"""""""""""""""""""""""""""""""""""""
" => Text, tab, and indent
"""""""""""""""""""""""""""""""""""""
" auto indent
set autoindent

" NOTE:
"   do not use ":set smartindent"
"   because it conflicts with
"   filetype-based indentation

if has("autocmd")
    " enable filetype plugins
    filetype plugin indent on

    " 8-wide real tab char in Makefiles
    autocmd FileType make set tabstop=8 shiftwidth=8 softtabstop=0 noexpandtab
endif

" width of tab character
set tabstop=8

" number of spaces for autoindent
set shiftwidth=4

" width when pressing tab key
set softtabstop=4

" inserts softtabstop characters instead of tabs
set expandtab

"""""""""""""""""""""""""""""""""""""
" => Mappings
"""""""""""""""""""""""""""""""""""""
" turn off highlighting and clear message with space bar
nnoremap <silent> <Space> :nohlsearch<Bar>:echo<CR>

" going to the next search centers the result
map N Nzz
map n nzz

" cursor behaves as expected with wrapped lines
inoremap <Down> <C-o>gj
inoremap <Up> <C-o>gk

" remap VIM 0 to first non-blank character
" map 0 ^



" greet user
if has("autocmd")
    autocmd VimEnter * echo "custom .vimrc file loaded"
endif

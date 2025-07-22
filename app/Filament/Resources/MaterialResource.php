<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MaterialResource\Pages;
use App\Helpers\SupabaseUploader;
use App\Models\Material;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class MaterialResource extends Resource
{
    protected static ?string $model = Material::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\TextInput::make('title')->required(),
            Forms\Components\Select::make('type')
                ->options([
                    'article' => 'Artikel',
                    'pdf' => 'PDF',
                    'video' => 'Video',
                    'audio' => 'Audio',
                    'image' => 'Gambar',
                ])
                ->required(),

            Forms\Components\Textarea::make('content')
                ->visible(fn ($get) => $get('type') === 'article'),

            Forms\Components\FileUpload::make('file_path')
                ->visible(fn ($get) => $get('type') !== 'article')
                ->acceptedFileTypes(['application/pdf', 'image/*', 'video/*', 'audio/*'])
                ->preserveFilenames()
                ->getUploadedFileNameForStorageUsing(function ($file) {

                    return Str::random(40) . '.' . $file->getClientOriginalExtension();
                })
                ->storeFiles(false) 
                ->dehydrated(false) 
                ->afterStateUpdated(function ($state, callable $set, callable $get, $record) {
                    if ($state) {
                        $file = $state;
                        $path = SupabaseUploader::upload($file);
                        if ($path) {
                            $set('file_path', $path); 
                        }
                    }
                }),

            Forms\Components\Select::make('status')
                ->options([
                    'pending' => 'Pending',
                    'approved' => 'Approved',
                ])
                ->required(),

            Forms\Components\Select::make('user_id')
                ->relationship('user', 'name')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label('Judul')->searchable(),
                TextColumn::make('type')->label('Tipe')->sortable(),
                BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'approved',
                    ])
                    ->label('Status'),
                TextColumn::make('user.name')->label('Pengunggah')->sortable(),
                TextColumn::make('created_at')->label('Tanggal')->dateTime('d M Y, H:i'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Disetujui',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMaterials::route('/'),
            'create' => Pages\CreateMaterial::route('/create'),
            'edit' => Pages\EditMaterial::route('/{record}/edit'),
        ];
    }
}

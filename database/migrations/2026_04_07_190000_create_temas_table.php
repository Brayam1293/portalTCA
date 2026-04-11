public function up()
{
    Schema::create('temas', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->text('message');
        $table->unsignedBigInteger('user_id');
        $table->integer('categoria');
        $table->timestamps();
    });
}
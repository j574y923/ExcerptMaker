# ExcerptMaker
Use regex and various string functions to create two excerpts from a text based on search terms.

# Example
Take the following example text:

Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.

Search the terms:

printer letraset

Code:

    $example = new ExcerptMaker();
    $example->Text = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.";
    $example->SearchTermsString = "printer letraset";
    $example->MakeTwoExcerpts();
    echo $example->Excerpt1 . "<br><br>";
    echo $example->Excerpt2;
    
Output:

...ever since the 1500s, when an unknown printer took a galley of type and scrambled it...

...in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently...

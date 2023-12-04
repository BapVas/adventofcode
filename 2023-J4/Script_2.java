import java.util.HashSet;
import java.util.Set;
import java.io.IOException;
import java.nio.file.Files;
import java.nio.file.Path;
import java.util.Arrays;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

public class Script_2 {
    public static void main(String[] args) throws IOException
    {
        String input = Files.readString(Path.of("data.txt"));
        String[] rows = input.split(System.lineSeparator());
        int[] res = new int[rows.length];
        Arrays.fill(res, 1);

        for (int i = 0; i < rows.length; i++) {
            System.out.print("Row #" + i);
            for (int j = 1; j <= res[i]; j++) {
                getChildCardNumbers(rows, i, res);
            }
            System.out.println("Row #" + i + " -> " + res[i]);
        }

        int sum = Arrays.stream(res).sum();
        System.out.println(sum);
    }

    private static int getCardNumbers(String row)
    {
        String[] parts = row.split(":");
        String cardNumbers = parts[1].trim();

        String[] numberSets = cardNumbers.split("\\|");
        String validNumbers = numberSets[0].trim();
        String myNumbers = numberSets[1].trim();

        Matcher validNumbersMatcher = Pattern.compile("\\d+").matcher(validNumbers);
        Matcher myNumbersMatcher = Pattern.compile("\\d+").matcher(myNumbers);

        Set<String> validNumbersSet = new HashSet<>();
        while (validNumbersMatcher.find()) {
            validNumbersSet.add(validNumbersMatcher.group());
        }

        Set<String> myNumberSet = new HashSet<>();
        while (myNumbersMatcher.find()) {
            myNumberSet.add(myNumbersMatcher.group());
        }

        myNumberSet.retainAll(validNumbersSet);

        return myNumberSet.size();
    }

    private static void getChildCardNumbers(String[] rows, int index, int[] res)
    {
        if (index >= rows.length) {
            return;
        }

        int validNumbers = getCardNumbers(rows[index]);

        for (int j = 1; j <= validNumbers; j++) {
            if (index + j < res.length) {
                res[index + j]++;
            }
        }
    }
}
